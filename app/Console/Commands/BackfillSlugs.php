<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\StudyMaterial;
use Illuminate\Console\Command;

class BackfillSlugs extends Command
{
    protected $signature = 'slugs:backfill';
    protected $description = 'Generate slugs for existing Course and StudyMaterial records that dont have one';

    public function handle(): int
    {
        $this->info('Backfilling Course slugs...');
        Course::whereNull('slug')->orWhere('slug', '')->chunkById(100, function ($courses) {
            foreach ($courses as $course) {
                $course->slug = $course->generateUniqueSlug();
                $course->saveQuietly(); // events trigger nahi honge, direct save
                $this->line("Course #{$course->id} -> {$course->slug}");
            }
        });

        $this->info('Backfilling StudyMaterial slugs...');
        StudyMaterial::whereNull('slug')->orWhere('slug', '')->chunkById(100, function ($materials) {
            foreach ($materials as $material) {
                $material->slug = $material->generateUniqueSlug();
                $material->saveQuietly();
                $this->line("StudyMaterial #{$material->id} -> {$material->slug}");
            }
        });

        $this->info('Done! Sab slugs generate ho gaye.');
        return self::SUCCESS;
    }
}