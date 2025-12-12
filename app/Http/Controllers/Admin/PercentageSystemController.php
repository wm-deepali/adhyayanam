<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PercentageSystem;
use Illuminate\Http\Request;

class PercentageSystemController extends Controller
{
    public function index()
    {
        $percentages = PercentageSystem::orderBy('id', 'desc')->get();
        return view('admin.percentage.index', compact('percentages'));
    }

    public function create()
    {
        return view('admin.percentage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_percentage' => 'required|numeric|min:0|max:100',
            'to_percentage'   => 'required|numeric|min:0|max:100|gte:from_percentage',
            'division'         => 'required|string',
            'status'          => 'required|in:active,inactive',
        ]);

        PercentageSystem::create($request->all());

        return redirect()->route('percentage.system.index')->with('success', 'Percentage range added successfully.');
    }

    public function edit($id)
    {
        $percentage = PercentageSystem::findOrFail($id);
        return view('admin.percentage.edit', compact('percentage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'from_percentage' => 'required|numeric|min:0|max:100',
            'to_percentage'   => 'required|numeric|min:0|max:100|gte:from_percentage',
            'division'         => 'required|string',
            'status'          => 'required|in:active,inactive',
        ]);

        $percentage = PercentageSystem::findOrFail($id);
        $percentage->update($request->all());

        return redirect()->route('percentage.system.index')->with('success', 'Percentage updated successfully.');
    }

    public function destroy($id)
    {
        PercentageSystem::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully.');
    }
}
