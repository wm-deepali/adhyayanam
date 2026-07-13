<?php

namespace App\Http\Controllers;

use App\Models\BackupSetting;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class BackupController extends Controller
{
    protected GoogleDriveService $drive;

    public function __construct(GoogleDriveService $drive)
    {
        $this->drive = $drive;
    }

    /**
     * Backup settings page + list of backups already on Google Drive
     */
    public function index()
    {
        $settings = BackupSetting::current();

        try {
            $driveFiles = $this->drive->listFiles();
        } catch (Exception $e) {
            Log::error('Failed to list Drive backups: ' . $e->getMessage());
            $driveFiles = [];
            session()->flash('error', 'Could not fetch backup list from Google Drive: ' . $e->getMessage());
        }

        return view('backup.index', [
            'settings' => $settings,
            'driveFiles' => $driveFiles,
        ]);
    }

    /**
     * Save Auto/Manual settings form
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:manual,auto',
            'frequency' => 'nullable|in:daily,weekly,monthly',
            'run_time' => 'nullable|date_format:H:i',
            'keep_last' => 'required|integer|min:1|max:100',
        ]);

        $settings = BackupSetting::current();
        $settings->update($validated);

        return back()->with('success', 'Backup settings saved successfully.');
    }

    /**
     * Run backup now: spatie creates a local zip, then we upload it to Drive
     * and delete the local copy (to save server storage)
     */
    public function backupNow()
    {
        set_time_limit(300); // allow up to 5 minutes for execution

        try {
            // Step 1: Let spatie create the local zip
            Artisan::call('backup:run'); // now backs up both DB and files
            $output = Artisan::output();

            // Step 2: Find the latest zip in the local backup folder
            $backupName = config('backup.backup.name', config('app.name'));
            $backupPath = storage_path('app/' . $backupName);

            if (!File::exists($backupPath)) {
                throw new Exception('Backup folder not found: ' . $backupPath);
            }

            $files = collect(File::files($backupPath))
                ->sortByDesc(fn($file) => $file->getMTime())
                ->values();

            if ($files->isEmpty()) {
                throw new Exception('No zip file was created. Artisan output: ' . $output);
            }

            $latestZip = $files->first()->getPathname();

            // Step 3: Upload to Google Drive
            $this->drive->uploadFile($latestZip, basename($latestZip));

            // Step 4: Delete the local zip (save server space)
            File::delete($latestZip);

            // Step 5: Clean up old backups on Drive (beyond keep_last)
            $this->cleanupOldBackups();

            $settings = BackupSetting::current();
            $settings->update(['last_run_at' => now()]);

            return back()->with('success', 'Backup created successfully and uploaded to Google Drive.');
        } catch (Exception $e) {
            Log::error('Backup failed: ' . $e->getMessage());
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Restore: download the zip from Drive, extract it, and run the SQL file via PDO
     * (cPanel-safe — no exec()/shell commands used)
     *
     * A safety-backup of the current DB is taken before restoring, so we can
     * roll back if something goes wrong.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'file_id' => 'required|string',
        ]);

        set_time_limit(300);

        $tempPath = storage_path('app/temp_restore_' . time() . '.zip');
        $extractPath = storage_path('app/temp_restore_' . time());

        try {
            // Step 0: Safety net — take a local backup of the current DB before restoring
            $this->createSafetyBackup();

            // Step 1: Download from Drive
            $this->drive->downloadFile($request->input('file_id'), $tempPath);

            // Step 2: Extract the zip
            File::makeDirectory($extractPath, 0755, true, true);

            $zip = new \ZipArchive();
            if ($zip->open($tempPath) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                throw new Exception('Failed to extract the zip file.');
            }

            // Step 3: Find the DB dump
            $sqlFiles = File::glob($extractPath . '/db-dumps/*.sql');

            if (empty($sqlFiles)) {
                throw new Exception('No .sql dump found in the zip.');
            }

            $sqlFile = $sqlFiles[0];

            // Step 4: Execute the SQL file via PDO
            $this->executeSqlFile($sqlFile);
            $this->restoreFiles($extractPath);

            // Step 5: Clean up temp files
            File::delete($tempPath);
            File::deleteDirectory($extractPath);

            return back()->with('success', 'Database restored successfully. (A safety backup was also created at storage/app/pre_restore_safety_backup.zip)');
        } catch (Exception $e) {
            // Cleanup even on failure
            if (File::exists($tempPath)) {
                File::delete($tempPath);
            }
            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }

            Log::error('Restore failed: ' . $e->getMessage());
            return back()->with('error', 'Restore failed: ' . $e->getMessage() . ' — If data got corrupted, you can restore from storage/app/pre_restore_safety_backup.zip.');
        }
    }

    /**
     * Take a quick safety dump of the current database before restoring, and
     * store it under a separate name (to avoid overlapping with backupNow()'s zip).
     * If the restore fails or bad data comes in, you can quickly restore from this file.
     */
    protected function createSafetyBackup(): void
    {
        Artisan::call('backup:run'); // now backs up both DB and files

        $backupName = config('backup.backup.name', config('app.name'));
        $backupPath = storage_path('app/' . $backupName);

        if (!File::exists($backupPath)) {
            Log::warning('Safety backup: backup folder not found, skipping.');
            return;
        }

        $files = collect(File::files($backupPath))
            ->sortByDesc(fn($file) => $file->getMTime())
            ->values();

        if ($files->isNotEmpty()) {
            $latestZip = $files->first()->getPathname();

            // Overwrite the old safety copy with the new one
            $safetyPath = storage_path('app/pre_restore_safety_backup.zip');
            File::copy($latestZip, $safetyPath);
            File::delete($latestZip);

            Log::info('Safety backup created before restore: ' . $safetyPath);
        }
    }

    /**
     * Reads a .sql dump file and executes it statement-by-statement via PDO.
     *
     * Note: Transaction wrapping is intentionally omitted — mysqldump output
     * contains DDL statements (CREATE/DROP TABLE) which implicitly commit any
     * open transaction in MySQL. So our manual transaction wasn't working
     * anyway and was causing a "There is no active transaction" error.
     * Real safety comes from createSafetyBackup() (above).
     */
    protected function executeSqlFile(string $sqlFile): void
    {
        $pdo = \DB::connection()->getPdo();

        // Turn off foreign key checks so table creation/insert order doesn't matter
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');

        $handle = fopen($sqlFile, 'r');
        $buffer = '';

        while (($line = fgets($handle)) !== false) {
            $trimmed = trim($line);

            // Skip comments and empty lines
            if ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                continue;
            }

            $buffer .= $line;

            // A statement ends when the line ends with a semicolon
            if (str_ends_with($trimmed, ';')) {
                try {
                    $pdo->exec($buffer);
                } catch (\PDOException $e) {
                    // Some statements (like DEFINER views) may fail — log and continue
                    Log::warning('SQL statement skipped: ' . $e->getMessage());
                }
                $buffer = '';
            }
        }

        fclose($handle);

        $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Delete a backup from Drive (for the manual delete button)
     */
    public function destroy(Request $request)
    {
        $request->validate(['file_id' => 'required|string']);

        try {
            $this->drive->deleteFile($request->input('file_id'));
            return back()->with('success', 'Backup deleted from Google Drive.');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorBody = $e->getResponse()->getBody()->getContents();
            Log::error('Delete failed (Google API response): ' . $errorBody);
            return back()->with('error', 'Delete failed: ' . $errorBody);
        } catch (Exception $e) {
            Log::error('Delete failed: ' . $e->getMessage());
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove backups from Drive that exceed the keep_last setting
     */
    protected function cleanupOldBackups(): void
    {
        $settings = BackupSetting::current();
        $files = $this->drive->listFiles(); // already newest-first sorted

        if (count($files) > $settings->keep_last) {
            $toDelete = array_slice($files, $settings->keep_last);

            foreach ($toDelete as $file) {
                try {
                    $this->drive->deleteFile($file['id']);
                } catch (Exception $e) {
                    Log::warning("Failed to delete old backup: {$file['name']} - " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Copies any storage/public files found inside the backup zip back to
     * their original location.
     */
    protected function restoreFiles(string $extractPath): void
    {
        // The folder structure inside the zip mirrors the backup's 'include' paths
        // e.g. storage/app/public goes back to storage/app/public
        $possiblePaths = [
            storage_path('app/public') => $extractPath . '/storage/app/public',
            public_path('uploads') => $extractPath . '/public/uploads',
        ];

        foreach ($possiblePaths as $destination => $source) {
            if (File::exists($source)) {
                File::copyDirectory($source, $destination);
                Log::info("Files restored: {$source} -> {$destination}");
            }
        }
    }
}