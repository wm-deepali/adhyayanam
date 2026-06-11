<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageSection;
use App\Models\AboutPageCounter;
use App\Models\AboutPageHighlight;
use App\Models\AboutPageStrength;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        $sections = [
            'Hero Section',
            'Counter Section',
            'Who We Are',
            'Academic Highlights',
            'Why Choose Us',
            'Our Commitments',
            'Join Us',
        ];

        return view('admin.about.index', compact('sections'));
    }

    /* ==========================================
                HERO SECTION
    ========================================== */

    public function hero()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'hero']
        );

        return view('admin.about.hero', compact('section'));
    }

    public function storeHero(Request $request)
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'hero']
        );

        $section->update([
            'heading' => $request->heading,
            'extra_data' => [
                'sub_heading' => $request->sub_heading
            ]
        ]);

        return back()->with('success', 'Hero section updated successfully.');
    }

    /* ==========================================
                COUNTERS
    ========================================== */

    public function counter()
    {
        $counters = AboutPageCounter::orderBy('sort_order')->get();

        return view('admin.about.counter', compact('counters'));
    }

    public function storeCounter(Request $request)
    {
        AboutPageCounter::truncate();

        if ($request->label) {

            foreach ($request->label as $key => $label) {

                if (!$label) {
                    continue;
                }

                AboutPageCounter::create([
                    'value' => $request->value[$key],
                    'label' => $label,
                    'sort_order' => $key + 1
                ]);
            }
        }

        return back()->with('success', 'Counters updated successfully.');
    }

    /* ==========================================
                WHO WE ARE
    ========================================== */

    public function whoWeAre()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'who_we_are']
        );

        return view('admin.about.who-we-are', compact('section'));
    }

    public function storeWhoWeAre(Request $request)
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'who_we_are']
        );

        $data = [
            'sub_title' => $request->sub_title,
            'heading' => $request->heading,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('about', 'public');
        }

        $section->update($data);

        return back()->with('success', 'Who We Are updated successfully.');
    }

    /* ==========================================
            ACADEMIC HIGHLIGHTS
    ========================================== */

    public function academicHighlights()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'academic_highlights']
        );

        $highlights = AboutPageHighlight::orderBy('sort_order')->get();

        return view(
            'admin.about.academic-highlights',
            compact('section', 'highlights')
        );
    }

    public function storeAcademicHighlights(Request $request)
    {
        $section = AboutPageSection::firstOrCreate([
            'section_key' => 'academic_highlights'
        ]);

        $extraData = $section->extra_data ?? [];

        if ($request->hasFile('image_1')) {
            $extraData['image_1'] = $request
                ->file('image_1')
                ->store('about', 'public');
        }

        if ($request->hasFile('image_2')) {
            $extraData['image_2'] = $request
                ->file('image_2')
                ->store('about', 'public');
        }

        $section->update([
            'sub_title' => $request->sub_title,
            'heading' => $request->heading,
            'description' => $request->short_description,
            'extra_data' => $extraData,
        ]);

        AboutPageHighlight::truncate();

        if ($request->card_heading) {

            foreach ($request->card_heading as $key => $heading) {

                if (!$heading) {
                    continue;
                }

                AboutPageHighlight::create([
                    'icon' => $request->card_icon[$key] ?? null,
                    'heading' => $heading,
                    'short_description' => $request->card_description[$key] ?? null,
                    'sort_order' => $key + 1,
                ]);
            }
        }

        return back()->with(
            'success',
            'Academic Highlights updated successfully.'
        );
    }

    /* ==========================================
                WHY CHOOSE US
    ========================================== */

    public function whyChooseUs()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'why_choose_us']
        );

        $strengths = AboutPageStrength::orderBy('sort_order')->get();

        return view(
            'admin.about.why-choose-us',
            compact('section', 'strengths')
        );
    }

    public function storeWhyChooseUs(Request $request)
    {
        $section = AboutPageSection::firstOrCreate([
            'section_key' => 'why_choose_us'
        ]);

        $extraData = $section->extra_data ?? [];

        if ($request->hasFile('image')) {

            $extraData['image'] = $request
                ->file('image')
                ->store('about', 'public');
        }

        $extraData['quote'] = $request->quote;

        $section->update([
            'sub_title' => $request->sub_title,
            'heading' => $request->heading,
            'description' => $request->description,
            'extra_data' => $extraData,
        ]);

        AboutPageStrength::truncate();

        if ($request->strength_title) {

            foreach ($request->strength_title as $key => $title) {

                if (empty($title)) {
                    continue;
                }

                AboutPageStrength::create([
                    'title' => $title,
                    'sort_order' => $key + 1
                ]);
            }
        }

        return back()->with(
            'success',
            'Why Choose Us updated successfully.'
        );
    }

    /* ==========================================
                COMMITMENTS
    ========================================== */

    public function commitments()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'commitments']
        );

        return view('admin.about.commitments', compact('section'));
    }

    public function storeCommitments(Request $request)
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'commitments']
        );

        $data = [
            'heading' => $request->heading,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('about', 'public');
        }

        $section->update($data);

        return back()->with('success', 'Commitments updated successfully.');
    }

    /* ==========================================
                    JOIN US
    ========================================== */

    public function joinUs()
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'join_us']
        );

        return view('admin.about.join-us', compact('section'));
    }

    public function storeJoinUs(Request $request)
    {
        $section = AboutPageSection::firstOrCreate(
            ['section_key' => 'join_us']
        );

        $data = [
            'heading' => $request->heading,
            'description' => $request->description,
            'extra_data' => [
                'button_1_name' => $request->button_1_name,
                'button_1_link' => $request->button_1_link,
                'button_2_name' => $request->button_2_name,
                'button_2_link' => $request->button_2_link,
            ]
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('about', 'public');
        }

        $section->update($data);

        return back()->with('success', 'Join Us updated successfully.');
    }
}