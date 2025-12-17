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

        // 🔍 Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(20);

        return view('admin.homework.index', compact('submissions'));
    }


    public function edit($id)
    {
        $submission = StudentHomeworkSubmission::with([
            'student','teacher','video'
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
