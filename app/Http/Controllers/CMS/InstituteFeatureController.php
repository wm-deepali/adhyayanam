<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstituteFeature;
use Illuminate\Support\Facades\Storage;

class InstituteFeatureController extends Controller
{
    public function index()
    {
        $features = InstituteFeature::orderBy('sort_order')->get();
        return view('admin.cms.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'short_description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('features','public');
        }

        InstituteFeature::create($data);

        return back()->with('success','Feature added');
    }

    public function update(Request $request, $id)
    {
        $feature = InstituteFeature::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'short_description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($feature->image);
            $data['image'] = $request->file('image')->store('features','public');
        }

        $feature->update($data);

        return back()->with('success','Feature updated');
    }

    public function destroy($id)
    {
        $feature = InstituteFeature::findOrFail($id);
        Storage::disk('public')->delete($feature->image);
        $feature->delete();

        return back()->with('success','Deleted');
    }
}