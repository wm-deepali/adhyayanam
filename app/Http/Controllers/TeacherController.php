<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function show($id)
    {
        // dd('here');
        $teacher = Teacher::findOrFail($id);
        return view('teachers.profile.show', compact('teacher'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $teacher = auth()->guard('teacher')->user();
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        return redirect()->route('teacher.show', auth()->guard('teacher')->user()->id)
            ->with('status', 'Password changed successfully!');

    }

}
