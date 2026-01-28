<?php

namespace App\Http\Controllers;

use App\Models\FeedTestimonial;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /* LIST */
    public function feedIndex()
    {
        $feeds = FeedTestimonial::where('type', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('enquiries.feedback', compact('feeds'));
    }

    public function testimonialsIndex()
    {
        $feeds = FeedTestimonial::where('type', 2)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('enquiries.testimonial', compact('feeds'));
    }

    /* VIEW */
    public function show($id)
    {
        $feed = FeedTestimonial::findOrFail($id);
        return view('enquiries.feedback-view', compact('feed'));
    }

    /* STATUS UPDATE */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3',
        ]);

        FeedTestimonial::where('id', $id)->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    /* DELETE */
    public function delete($id)
    {
        FeedTestimonial::where('id', $id)->delete();
        return back()->with('success', 'Feedback deleted successfully.');
    }
}