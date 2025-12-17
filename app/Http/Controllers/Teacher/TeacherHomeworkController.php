<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentHomeworkSubmission;
use Illuminate\Http\Request;

class TeacherHomeworkController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentHomeworkSubmission::with([
            'student',
            'video',
        ])->where('teacher_id', auth()->id());

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $submissions = $query->latest()->paginate(15);

        return view('teachers.homework.index', compact('submissions'));
    }

    public function edit($id)
    {
        $submission = StudentHomeworkSubmission::with([
            'student',
            'video'
        ])
            ->where('teacher_id', auth()->id())
            ->findOrFail($id);

        return view('teachers.homework.edit', compact('submission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:checked,reviewed,rejected,resubmitted',
            'marks' => 'nullable|numeric|min:0',
            'teacher_remark' => 'nullable|string|max:2000',
        ]);

        $submission = StudentHomeworkSubmission::where('teacher_id', auth()->id())
            ->findOrFail($id);

        $submission->update([
            'status' => $request->status,
            'marks' => $request->marks,
            'teacher_remark' => $request->teacher_remark,
            'checked_at' => now(),
        ]);

        return redirect()
            ->route('teacher.homework.index')
            ->with('success', 'Homework evaluated successfully.');
    }

}
