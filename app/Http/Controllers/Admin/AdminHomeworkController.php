<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentHomeworkSubmission;
use Illuminate\Http\Request;

class AdminHomeworkController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentHomeworkSubmission::with([
            'student:id,first_name,last_name,email',
            'video:id,title,solution_file,assignment_file',
            'teacher:id,full_name'
        ])->latest();

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by video title OR teacher name (added by)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('video', function ($v) use ($search) {
                    $v->where('title', 'like', "%{$search}%");
                })->orWhereHas('teacher', function ($t) use ($search) {
                    $t->where('full_name', 'like', "%{$search}%");
                })->orWhereHas('student', function ($t) use ($search) {
                    $t->where('first_name', 'like', "%{$search}%");
                    $t->orwhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        $submissions = $query
            ->paginate(10)
            ->withQueryString(); // keep filters on pagination

        return view('admin.homework.index', compact('submissions'));
    }



    public function edit($id)
    {
        $submission = StudentHomeworkSubmission::with([
            'student',
            'teacher',
            'video'
        ])->findOrFail($id);

        return view('admin.homework.edit', compact('submission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'marks' => 'nullable|numeric|min:0',
            'teacher_remark' => 'nullable|string|max:2000',
        ]);

        StudentHomeworkSubmission::findOrFail($id)->update([
            'status' => $request->status,
            'marks' => $request->marks,
            'teacher_remark' => $request->teacher_remark,
            'checked_at' => now(),
        ]);

        return redirect()
            ->route('admin.homework.index')
            ->with('success', 'Assignment updated successfully.');
    }

}
