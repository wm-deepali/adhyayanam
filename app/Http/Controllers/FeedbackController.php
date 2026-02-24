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

    public function create()
    {
        return view('enquiries.testimonial-create');
    }

    /**
     * Store testimonial (admin)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|integer',
            'username' => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'number' => 'nullable|string|max:20',
            'message' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // upload photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feed-photos'), $filename);
            $data['photo'] = $filename;
        }

        // default values
        $data['status'] = 1; // active
        $data['designation'] = $data['designation'] ?? 'Student';

        FeedTestimonial::create($data);

        return redirect()
            ->route('testimonials.index')
            ->with('success', 'Testimonial added successfully');
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