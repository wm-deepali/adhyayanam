<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    /**
     * Show all home page sections
     */
    public function index()
    {
        // fetch & key by section_key for easier access
        $sections = PageContent::orderBy('id')->get();

        return view('admin.cms.home_sections', compact('sections'));
    }

    /**
     * Update headings & subheadings
     */
    public function update(Request $request)
    {
        // ✅ validation
        $request->validate([
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.sub_heading' => 'nullable|string|max:500',
        ]);

        foreach ($request->sections as $key => $data) {

            PageContent::updateOrCreate(
                ['section_key' => $key],
                [
                    'heading' => $data['heading'] ?? null,
                    'sub_heading' => $data['sub_heading'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Home page sections updated successfully.');
    }
}