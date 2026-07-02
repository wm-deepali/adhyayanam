<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Str;

class GenerateCategorySlugs extends Command
{
    protected $signature = 'category:generate-slugs';

    protected $description = 'Generate unique slugs for existing categories';

    public function handle()
    {
        $usedSlugs = [];

        Category::chunk(100, function ($categories) use (&$usedSlugs) {

            foreach ($categories as $category) {

                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $count = 1;

                while (
                    in_array($slug, $usedSlugs) ||
                    Category::where('slug', $slug)
                        ->where('id', '!=', $category->id)
                        ->exists()
                ) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }

                $category->updateQuietly([
                    'slug' => $slug
                ]);

                $usedSlugs[] = $slug;

                $this->info("{$category->name} => {$slug}");
            }
        });

        $this->info('Category slugs generated successfully.');
    }
}