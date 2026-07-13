<?php

namespace App\Services;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleDriveService
{
    protected Client $client;
    protected string $credentialsPath;
    protected string $folderId; // ye ab Shared Drive ka root ID ya andar ka folder ID, dono ho sakta hai
    protected string $driveId;  // Shared Drive ka ID (jo humesha ek jaisa rahega)
    protected array $credentials;

    public function __construct()
    {
        $this->client = new Client();
        $this->credentialsPath = base_path(env('GOOGLE_DRIVE_CREDENTIALS_PATH', 'storage/app/google-credentials.json'));
        $this->folderId = env('GOOGLE_DRIVE_FOLDER_ID');
        $this->driveId = env('GOOGLE_DRIVE_ID', $this->folderId); // agar alag se drive ID na di ho, folderId ko hi driveId maan lo

        if (!file_exists($this->credentialsPath)) {
            throw new Exception("Google credentials file not found at: {$this->credentialsPath}");
        }

        $this->credentials = json_decode(file_get_contents($this->credentialsPath), true);
    }

    protected function getAccessToken(): string
    {
        return Cache::remember('google_drive_access_token', 3300, function () {
            $now = time();

            $jwtPayload = [
                'iss'   => $this->credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/drive',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'iat'   => $now,
                'exp'   => $now + 3600,
            ];

            $jwt = JWT::encode($jwtPayload, $this->credentials['private_key'], 'RS256');

            $response = $this->client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion'  => $jwt,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return $body['access_token'];
        });
    }

    public function uploadFile(string $filePath, ?string $fileName = null): array
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        $fileName = $fileName ?? basename($filePath);
        $accessToken = $this->getAccessToken();

        $metadata = [
            'name'    => $fileName,
            'parents' => [$this->folderId],
        ];

        $response = $this->client->post('https://www.googleapis.com/upload/drive/v3/files', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'query' => [
                'uploadType'          => 'multipart',
                'supportsAllDrives'   => 'true', // Shared Drives ke liye zaroori
            ],
            'multipart' => [
                [
                    'name'     => 'metadata',
                    'contents' => json_encode($metadata),
                    'headers'  => ['Content-Type' => 'application/json'],
                ],
                [
                    'name'     => 'file',
                    'contents' => fopen($filePath, 'r'),
                    'filename' => $fileName,
                ],
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        Log::info("Backup uploaded to Google Drive: {$fileName}", $result);

        return $result;
    }

    public function listFiles(): array
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->get('https://www.googleapis.com/drive/v3/files', [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'query' => [
                'q'                         => "'{$this->folderId}' in parents and trashed = false",
                'fields'                    => 'files(id, name, size, createdTime, modifiedTime)',
                'orderBy'                   => 'createdTime desc',
                'supportsAllDrives'         => 'true',
                'includeItemsFromAllDrives' => 'true',
                'corpora'                   => 'drive',
                'driveId'                   => $this->driveId,
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['files'] ?? [];
    }

    public function downloadFile(string $fileId, string $destinationPath): bool
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->get("https://www.googleapis.com/drive/v3/files/{$fileId}", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'query' => [
                'alt'               => 'media',
                'supportsAllDrives' => 'true',
            ],
            'sink' => $destinationPath,
        ]);

        return $response->getStatusCode() === 200;
    }

  /**
     * File ko Google Drive Trash me bhej deta hai (permanent delete nahi karta).
     * Isse kam permission chahiye hoti hai (Content Manager role kaafi hai),
     * aur agar galti se delete ho jaye to Trash se recover bhi kiya ja sakta hai.
     */
    public function deleteFile(string $fileId): bool
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->patch("https://www.googleapis.com/drive/v3/files/{$fileId}", [
            'headers' => [
                'Authorization'  => "Bearer {$accessToken}",
                'Content-Type'   => 'application/json',
            ],
            'query' => [
                'supportsAllDrives' => 'true',
            ],
            'body' => json_encode(['trashed' => true]),
        ]);

        return $response->getStatusCode() === 200;
    }
}