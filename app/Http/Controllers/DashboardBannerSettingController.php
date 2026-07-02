<?php

namespace App\Http\Controllers;

use App\Models\DashboardBannerSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DashboardBannerSettingController extends Controller
{
    public function index()
    {
        $banner = DashboardBannerSetting::first();
        return view('settings.dashboard-banner.index', compact('banner'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $banner = DashboardBannerSetting::first();

        if (!$banner) {
            $banner = new DashboardBannerSetting();
        }

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('dashboard-banner', 'public');
        }

        $banner->save();

        return redirect()->route('settings.dashboard-banner.index')
            ->with('success', 'Dashboard banner updated successfully');
    }
}