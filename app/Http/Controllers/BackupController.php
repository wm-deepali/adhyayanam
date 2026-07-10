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
            session()->flash('error', 'Google Drive se backup list nahi mil payi: ' . $e->getMessage());
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

        return back()->with('success', 'Backup settings save ho gayi.');
    }

    /**
     * Run backup now: spatie zip banayega locally, phir hum use Drive par upload karke
     * local copy delete kar denge (server storage bharne se bachane ke liye)
     */
    public function backupNow()
    {
        set_time_limit(300); // 5 minutes tak execution allow karo
        // try {
            // Step 1: Spatie se local zip banwao
            Artisan::call('backup:run', ['--only-db' => true]);
            $output = Artisan::output();

            // Step 2: Local backup folder me sabse naya zip dhoondo
            $backupName = config('backup.backup.name', config('app.name'));
            $backupPath = storage_path('app/' . $backupName);

            if (!File::exists($backupPath)) {
                throw new Exception('Backup folder nahi mila: ' . $backupPath);
            }

            $files = collect(File::files($backupPath))
                ->sortByDesc(fn($file) => $file->getMTime())
                ->values();

            if ($files->isEmpty()) {
                throw new Exception('Koi zip file nahi bani. Artisan output: ' . $output);
            }

            $latestZip = $files->first()->getPathname();

            // Step 3: Google Drive par upload karo
            $this->drive->uploadFile($latestZip, basename($latestZip));

            // Step 4: Local zip delete kar do (server space bachao)
            File::delete($latestZip);

            // Step 5: Purane backups Drive par se hatao (keep_last se zyada)
            $this->cleanupOldBackups();

            $settings = BackupSetting::current();
            $settings->update(['last_run_at' => now()]);

            return back()->with('success', 'Backup successfully bana aur Google Drive par upload ho gaya.');
        // } catch (Exception $e) {
        //     Log::error('Backup failed: ' . $e->getMessage());
        //     return back()->with('error', 'Backup fail ho gaya: ' . $e->getMessage());
        // }
    }

    /**
     * Restore: Drive se zip download karo, phir extract karke DB restore karo
     */
    /**
     * Restore: Drive se zip download karo, extract karke SQL file ko PDO se execute karo
     * (cPanel-safe — koi exec()/shell command use nahi hoti)
     */
    public function restore(Request $request)
    {
        $request->validate([
            'file_id' => 'required|string',
        ]);

        $tempPath = storage_path('app/temp_restore_' . time() . '.zip');
        $extractPath = storage_path('app/temp_restore_' . time());

        try {
            // Step 1: Drive se download karo
            $this->drive->downloadFile($request->input('file_id'), $tempPath);

            // Step 2: Zip extract karo
            File::makeDirectory($extractPath, 0755, true, true);

            $zip = new \ZipArchive();
            if ($zip->open($tempPath) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                throw new Exception('Zip file extract nahi ho payi.');
            }

            // Step 3: DB dump dhoondo
            $sqlFiles = File::glob($extractPath . '/db-dumps/*.sql');

            if (empty($sqlFiles)) {
                throw new Exception('Zip me koi .sql dump nahi mila.');
            }

            $sqlFile = $sqlFiles[0];

            // Step 4: SQL file ko PDO ke through execute karo
            $this->executeSqlFile($sqlFile);

            // Step 5: Cleanup temp files
            File::delete($tempPath);
            File::deleteDirectory($extractPath);

            return back()->with('success', 'Database successfully restore ho gaya.');
        } catch (Exception $e) {
            // Cleanup even on failure
            if (File::exists($tempPath)) {
                File::delete($tempPath);
            }
            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }

            Log::error('Restore failed: ' . $e->getMessage());
            return back()->with('error', 'Restore fail ho gaya: ' . $e->getMessage());
        }
    }

    /**
     * Ek .sql dump file ko read karke statement-by-statement PDO se run karta hai.
     * mysqldump ke output me statements semicolon (;) se end hote hain, aur
     * hum multi-line statements (jaise CREATE TABLE, INSERT with newlines) ko
     * bhi sahi se handle karte hain.
     */
    protected function executeSqlFile(string $sqlFile): void
    {
        $pdo = \DB::connection()->getPdo();

        // Foreign key checks temporarily off karo taaki table order ka issue na aaye
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
        $pdo->exec('SET AUTOCOMMIT=0;');
        $pdo->beginTransaction();

        try {
            $handle = fopen($sqlFile, 'r');
            $buffer = '';

            while (($line = fgets($handle)) !== false) {
                $trimmed = trim($line);

                // Comments aur empty lines skip karo
                if ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                    continue;
                }

                $buffer .= $line;

                // Statement semicolon par khatam hota hai (line ke end me)
                if (str_ends_with($trimmed, ';')) {
                    try {
                        $pdo->exec($buffer);
                    } catch (\PDOException $e) {
                        // Kuch statements (jaise DEFINER views) fail ho sakte hain — log karke aage badho
                        Log::warning('SQL statement skip hui: ' . $e->getMessage());
                    }
                    $buffer = '';
                }
            }

            fclose($handle);

            $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
            $pdo->commit();
            $pdo->exec('SET AUTOCOMMIT=1;');
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('SQL restore failed: ' . $e->getMessage());
        }
    }

    /**
     * Drive se ek backup delete karo (manual delete button ke liye)
     */
    public function destroy(Request $request)
    {
        $request->validate(['file_id' => 'required|string']);

        try {
            $this->drive->deleteFile($request->input('file_id'));
            return back()->with('success', 'Backup Drive se delete ho gaya.');
        } catch (Exception $e) {
            Log::error('Delete failed: ' . $e->getMessage());
            return back()->with('error', 'Delete fail ho gaya: ' . $e->getMessage());
        }
    }

    /**
     * keep_last setting se zyada purane backups Drive se hata do
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
                    Log::warning("Old backup delete nahi ho payi: {$file['name']} - " . $e->getMessage());
                }
            }
        }
    }
}