<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstituteHighlight;

class InstituteHighlightController extends Controller
{
    public function index()
    {
        $highlight = InstituteHighlight::with('points')->first();
        return view('admin.cms.highlights.index', compact('highlight'));
    }

    public function update(Request $request)
    {
        $highlight = InstituteHighlight::first() ?? new InstituteHighlight();

        $highlight->sub_title = $request->sub_title;
        $highlight->main_heading = $request->main_heading;
        $highlight->short_description = $request->short_description;
        $highlight->sub_sub_title = $request->sub_sub_title;

        if ($request->hasFile('image')) {
            $highlight->image = $request->file('image')
                ->store('highlights', 'public');
        }

        $highlight->save();

        // delete old points
        $highlight->points()->delete();

        if ($request->has('points')) {

            foreach ($request->points as $index => $point) {

                if (!empty($point['comment'])) {

                    $iconPath = null;

                    if ($request->hasFile("points.$index.icon_image")) {
                        $iconPath = $request->file("points.$index.icon_image")
                            ->store('highlight-icons', 'public');
                    }

                    $highlight->points()->create([
                        'icon_image' => $iconPath,
                        'comment' => $point['comment']
                    ]);
                }
            }
        }

        return back()->with('success', 'Highlights updated');
    }
}
