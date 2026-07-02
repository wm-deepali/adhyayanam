<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExaminationCommission;
use Illuminate\Support\Str;

class GenerateCommissionSlugs extends Command
{
    protected $signature = 'commission:generate-slugs';

    protected $description = 'Generate unique slugs for old commissions';

    public function handle()
    {
        $usedSlugs = [];

        ExaminationCommission::chunk(100, function ($commissions) use (&$usedSlugs) {

            foreach ($commissions as $commission) {

                $baseSlug = Str::slug($commission->name);
                $slug = $baseSlug;

                $count = 1;

                while (
                    in_array($slug, $usedSlugs) ||
                    ExaminationCommission::where('slug', $slug)
                        ->where('id', '!=', $commission->id)
                        ->exists()
                ) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }

                $commission->updateQuietly([
                    'slug' => $slug
                ]);

                $usedSlugs[] = $slug;

                $this->info("Updated: {$commission->name} => {$slug}");
            }
        });

        $this->info('All slugs generated successfully.');
    }
}