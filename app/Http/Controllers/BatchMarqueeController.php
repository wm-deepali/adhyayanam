<?php

namespace App\Http\Controllers;

use App\Models\BatchMarquee;
use Illuminate\Http\Request;

class BatchMarqueeController extends Controller
{
    public function index()
    {
        $marquees = BatchMarquee::latest()->paginate(10);

        return view('batch-marquee.index', compact('marquees'));
    }

    public function create()
    {
        return view('batch-marquee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        BatchMarquee::create([
            'content' => $request->content,
            'status'  => $request->status ?? 0,
        ]);

        return redirect()
            ->route('batch-marquee.index')
            ->with('success', 'Batch marquee created successfully.');
    }

    public function edit(BatchMarquee $batch_marquee)
    {
        return view('batch-marquee.edit', compact('batch_marquee'));
    }

    public function update(Request $request, BatchMarquee $batch_marquee)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $batch_marquee->update([
            'content' => $request->content,
            'status'  => $request->status ?? 0,
        ]);

        return redirect()
            ->route('batch-marquee.index')
            ->with('success', 'Batch marquee updated successfully.');
    }

    public function destroy(BatchMarquee $batch_marquee)
    {
        $batch_marquee->delete();

        return back()->with('success', 'Batch marquee deleted successfully.');
    }
}