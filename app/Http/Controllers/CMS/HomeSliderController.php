<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order')->get();
        return view('admin.cms.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'url' => 'nullable|url'
        ]);

        $slider = new HomeSlider();

        if ($request->hasFile('image')) {
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        $slider->button_name = $request->button_name;
        $slider->url = $request->url;
        $slider->save();

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $slider = HomeSlider::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        $slider->button_name = $request->button_name;
        $slider->url = $request->url;
        $slider->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $slider = HomeSlider::findOrFail($id);

        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return back()->with('success', 'Slider deleted');
    }
}