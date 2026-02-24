<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeIntroduction;

class HomeIntroController extends Controller
{
    public function index()
    {
        $intro = HomeIntroduction::with('highlights', 'updater')->first();
        return view('admin.cms.home_intro.index', compact('intro'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);

        $intro = HomeIntroduction::first() ?? new HomeIntroduction();

        if ($request->hasFile('image')) {
            $intro->image = $request->file('image')->store('intro', 'public');
        }

        $intro->heading = $request->heading;
        $intro->description = $request->description;
        $intro->updated_by = auth()->id();
        $intro->save();

        // save highlights
        if ($request->highlights) {
            // existing highlight IDs
            $existingIds = $intro->highlights()->pluck('id')->toArray();

            $submittedIds = [];

            if ($request->highlights) {

                foreach ($request->highlights as $highlight) {

                    if (!empty($highlight['text'])) {

                        if (!empty($highlight['id'])) {
                            // update existing
                            $intro->highlights()
                                ->where('id', $highlight['id'])
                                ->update([
                                    'text' => $highlight['text']
                                ]);

                            $submittedIds[] = $highlight['id'];

                        } else {
                            // create new
                            $new = $intro->highlights()->create([
                                'text' => $highlight['text']
                            ]);

                            $submittedIds[] = $new->id;
                        }
                    }
                }
            }

            // delete removed highlights
            $idsToDelete = array_diff($existingIds, $submittedIds);

            if (!empty($idsToDelete)) {
                $intro->highlights()->whereIn('id', $idsToDelete)->delete();
            }
        }

        return back()->with('success', 'Introduction updated successfully');
    }
}