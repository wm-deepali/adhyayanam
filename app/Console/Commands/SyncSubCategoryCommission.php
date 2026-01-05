<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubCategory;
use App\Models\Category;

class SyncSubCategoryCommission extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sync:subcategory-commission';

    /**
     * The console command description.
     */
    protected $description = 'Attach examination_commission_id to sub categories using category mapping';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting SubCategory commission sync...');

        $updated = 0;
        $skipped = 0;

        $subCategories = SubCategory::with('category')->get();

        foreach ($subCategories as $subCategory) {

            // ❌ Skip if no category
            if (!$subCategory->category) {
                $skipped++;
                continue;
            }

            // ❌ Skip if category has no commission
            if (!$subCategory->category->exam_com_id) {
                $skipped++;
                continue;
            }

            // ✅ Update only if missing or incorrect
            if (
                $subCategory->examination_commission_id
                != $subCategory->category->exam_com_id
            ) {
                $subCategory->examination_commission_id =
                    $subCategory->category->exam_com_id;

                $subCategory->save();
                $updated++;
            }
        }

        $this->info("✔ Sync completed");
        $this->info("✔ Updated: {$updated}");
        $this->info("⚠ Skipped: {$skipped}");

        return Command::SUCCESS;
    }
}
