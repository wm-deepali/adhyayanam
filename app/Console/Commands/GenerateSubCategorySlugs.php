<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class GenerateSubCategorySlugs extends Command
{
    protected $signature = 'subcategory:generate-slugs';

    protected $description = 'Generate unique slugs for existing sub categories';

    public function handle()
    {
        $usedSlugs = [];

        SubCategory::chunk(100, function ($subCategories) use (&$usedSlugs) {

            foreach ($subCategories as $subCategory) {

                $baseSlug = Str::slug($subCategory->name);
                $slug = $baseSlug;
                $count = 1;

                while (
                    in_array($slug, $usedSlugs) ||
                    SubCategory::where('slug', $slug)
                        ->where('id', '!=', $subCategory->id)
                        ->exists()
                ) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }

                $subCategory->updateQuietly([
                    'slug' => $slug
                ]);

                $usedSlugs[] = $slug;

                $this->info("{$subCategory->name} => {$slug}");
            }
        });

        $this->info('SubCategory slugs generated successfully.');
    }
}