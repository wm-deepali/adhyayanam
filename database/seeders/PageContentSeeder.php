<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        $sections = [

            [
                'section_key' => 'intro',
                'heading' => 'Welcome to ADHYAYANAM E-LEARNING',
                'sub_heading' => "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform",
            ],

            [
                'section_key' => 'courses',
                'heading' => 'Courses We Offer',
                'sub_heading' => "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform",
            ],

            [
                'section_key' => 'features',
                'heading' => 'ADHYAYANAM – Your Path to Success',
                'sub_heading' => "Unlimited Access to High-Quality Mock Tests Designed for UPSC, SSC, Banking, Railways, State PCS & All Major Exams",
            ],

            [
                'section_key' => 'current_affairs',
                'heading' => 'Current Affairs',
                'sub_heading' => "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform",
            ],

            [
                'section_key' => 'test_series',
                'heading' => 'Our Test Series',
                'sub_heading' => "Unlimited Access to High-Quality Mock Tests Designed for UPSC, SSC, Banking, Railways, State PCS & All Major Exams",
            ],

            [
                'section_key' => 'study_material',
                'heading' => 'Our Study Materials',
                'sub_heading' => "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform",
            ],

            [
                'section_key' => 'daily_booster',
                'heading' => 'Daily Booster Videos',
                'sub_heading' => "Trending Current Affairs Updates",
            ],

            [
                'section_key' => 'testimonials',
                'heading' => 'Our Successful Best Students',
                'sub_heading' => "Real stories from our toppers",
            ],

            [
                'section_key' => 'blogs',
                'heading' => 'Blogs',
                'sub_heading' => "Learn more from our news and articles",
            ],

            [
                'section_key' => 'faq',
                'heading' => 'Frequently Asked Questions',
                'sub_heading' => "",
            ],
        ];

        foreach ($sections as $section) {
            PageContent::updateOrCreate(
                ['section_key' => $section['section_key']], // condition
                $section // values to update
            );
        }
    }
}