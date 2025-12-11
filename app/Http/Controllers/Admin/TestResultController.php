<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentTestAttempt;
use App\Models\StudentTestAnswer;
use Illuminate\Http\Request;
use App\Models\Teacher;


class TestResultController extends Controller
{
    public function results()
    {
        return view('admin.results.index', [
            'pending' => StudentTestAttempt::where('status', 'pending')
                ->latest()
                ->paginate(20, ['*'], 'pending_page'),

            'under_review' => StudentTestAttempt::where('status', 'under_review')
                ->latest()
                ->paginate(20, ['*'], 'review_page'),

            'published' => StudentTestAttempt::where('status', 'published')
                ->latest()
                ->paginate(20, ['*'], 'published_page'),

            'teachers' => Teacher::all()
        ]);
    }


    /**
     * Show evaluation page
     */
    public function showEvaluation($id)
    {
        $attemptId = base64_decode($id);

        $attempt = StudentTestAttempt::with(['student', 'test'])
            ->where('id', $attemptId)
            ->firstOrFail();

        $mainAnswers = StudentTestAnswer::where('attempt_id', $attemptId)
            ->whereNull('parent_question_id')
            ->with('question')
            ->get();

        $childAnswers = StudentTestAnswer::where('attempt_id', $attemptId)
            ->whereNotNull('parent_question_id')
            ->with('childQuestion')
            ->get()
            ->groupBy('parent_question_id');

        // dd($childAnswers->toArray());
        $summary = [];

        foreach ($mainAnswers as $ans) {

            $type = trim($ans->question->question_type ?? 'NA');

            if (!isset($summary[$type])) {
                $summary[$type] = [
                    'total' => 0,
                    'correct' => 0,
                    'partial' => 0,
                    'incorrect' => 0,
                    'skipped' => 0,
                    'negative' => 0,
                    'obtained' => 0,
                    'has_pending' => false, // NEW
                ];
            }

            $summary[$type]['total']++;

            /*
            |--------------------------------------------------------------------------
            | STORY BASED QUESTIONS
            |--------------------------------------------------------------------------
            */
            if (strtolower($type) == 'story based') {

                $childSet = $childAnswers[$ans->question_id] ?? collect([]);

                if ($childSet->count() == 0) {
                    $summary[$type]['skipped']++;
                    continue;
                }

                foreach ($childSet as $child) {

                    if ($child->evaluation_status == 'pending') {
                        $summary[$type]['has_pending'] = true;
                        continue;
                    }

                    if (in_array($child->attempt_status, ['skipped', 'not_attempted'])) {
                        $summary[$type]['skipped']++;
                    }

                    if ($child->evaluation_status == 'correct') {
                        $summary[$type]['correct']++;
                        $summary[$type]['obtained'] += $child->obtained_marks;
                    }

                    if ($child->evaluation_status == 'partial') {
                        $summary[$type]['partial']++;
                        $summary[$type]['obtained'] += $child->obtained_marks;
                    }

                    if (in_array($child->evaluation_status, ['wrong', 'incorrect'])) {
                        $summary[$type]['incorrect']++;
                    }

                    if ($child->obtained_marks < 0) {
                        $summary[$type]['negative'] += abs($child->negative_mark);  // ✔ correct: sum of negative marks
                    }
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | NORMAL / SUBJECTIVE / MCQ QUESTIONS
            |--------------------------------------------------------------------------
            */

            if ($ans->evaluation_status == 'pending') {
                $summary[$type]['has_pending'] = true;
                continue;
            }

            if (in_array($ans->attempt_status, ['skipped', 'not_attempted'])) {
                $summary[$type]['skipped']++;
            }

            if ($ans->evaluation_status == 'correct' && $ans->obtained_marks > 0) {
                $summary[$type]['correct']++;
                $summary[$type]['obtained'] += $ans->obtained_marks;
            }

            if ($ans->evaluation_status == 'partial') {
                $summary[$type]['partial']++;
                $summary[$type]['obtained'] += $ans->obtained_marks;
            }

            if (in_array($ans->evaluation_status, ['wrong', 'incorrect'])) {
                $summary[$type]['incorrect']++;
            }

            if ($ans->obtained_marks < 0) {
                $summary[$type]['negative'] += abs($ans->negative_mark);  // ✔ correct: sum of negative marks
            }
        }

        return view('admin.results.evaluate', [
            'attempt' => $attempt,
            'mainAnswers' => $mainAnswers,
            'childGrouped' => $childAnswers,
            'summary' => $summary
        ]);
    }


    /**
     * Save evaluation marks
     */
    public function saveEvaluation(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required|integer',
            'final_status' => 'required|string|in:pending,under_review,published',
            'final_file' => 'nullable|file|max:50000'
        ]);
        
        $attempt = StudentTestAttempt::findOrFail($request->attempt_id);
   
        // If admin publishes, attempt becomes completed
        if ($request->final_status === 'published') {
            $attempt->status = 'published';
        }
        
        // ============================
        // 2️⃣ Save FINAL FILE only
        // ============================
        if ($request->hasFile('final_file')) {
            
            $file = $request->file('final_file');
            $name = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/evaluations', $name);
            
            $attempt->final_file = $name;
        }
        
        $attempt->save();
       
        return response()->json([
            'status' => true,
            'msg' => 'Evaluation submitted successfully.',
        ]);
    }


    public function assignMarks(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'marks' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $answer = StudentTestAnswer::find($request->question_id);

        if (!$answer) {
            return response()->json(['status' => false, 'msg' => 'Answer not found']);
        }

        $attempt = StudentTestAttempt::find($answer->attempt_id);

        /*
        |--------------------------------------------------------------------------
        | 1️⃣ Calculate difference
        |--------------------------------------------------------------------------
        */
        $oldMarks = $answer->obtained_marks ?? 0;
        $newMarks = $request->marks;
        $difference = $newMarks - $oldMarks;

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Update THIS answer only
        |--------------------------------------------------------------------------
        */
        $answer->obtained_marks = $newMarks;
        $answer->admin_remarks = $request->remarks ?? null;

        // File upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/evaluation_files', $name);

            $answer->admin_file = $name;
        }

        // Determine evaluation status
        $max = $answer->positive_mark;

        if ($newMarks == $max) {
            $answer->evaluation_status = 'correct';
        } elseif ($newMarks == 0) {
            $answer->evaluation_status = 'wrong';
        } elseif ($newMarks > 0 && $newMarks < $max) {
            $answer->evaluation_status = 'partial';
        } else {
            $answer->evaluation_status = 'evaluated';
        }

        $answer->requires_manual_check = false;
        $answer->save();


        /*
        |--------------------------------------------------------------------------
        | 3️⃣ Update RELATED attempt totals incrementally
        |--------------------------------------------------------------------------
        */
        // Update final score
        $attempt->final_score = ($attempt->final_score ?? 0) + $difference;

        // Update positive / negative score
        if ($newMarks > 0) {
            $attempt->earned_positive_score =
                ($attempt->earned_positive_score ?? 0) + ($newMarks - max($oldMarks, 0));
        }

        if ($newMarks < 0) {
            $attempt->earned_negative_score =
                ($attempt->earned_negative_score ?? 0) + (abs($newMarks) - abs(min($oldMarks, 0)));
        }

        // Update correct / wrong counters
        if ($answer->evaluation_status == 'correct') {
            $attempt->correct_count += ($oldMarks == $max ? 0 : 1);
            if ($oldMarks == 0)
                $attempt->wrong_count -= 1;
        }

        if ($answer->evaluation_status == 'wrong') {
            $attempt->wrong_count += ($oldMarks == 0 ? 0 : 1);
            if ($oldMarks == $max)
                $attempt->correct_count -= 1;
        }

        $attempt->save();
        return response()->json([
            'status' => true,
            'msg' => 'Marks updated successfully'
        ]);
    }


    public function deleteAttempt($id)
    {
        try {
            $attempt = StudentTestAttempt::with('test')->findOrFail($id);

            // Delete FINAL FILE if exists
            if (!empty($attempt->final_file) && \Storage::exists('public/evaluations/' . $attempt->final_file)) {
                \Storage::delete('public/evaluations/' . $attempt->final_file);
            }

            // Fetch all answers
            $answers = StudentTestAnswer::where('attempt_id', $attempt->id)->get();

            foreach ($answers as $ans) {

                // Delete student uploaded files
                if (!empty($ans->answer_file) && \Storage::exists('public/student_attempts/' . $ans->answer_file)) {
                    \Storage::delete('public/student_attempts/' . $ans->answer_file);
                }

                // Delete teacher file
                if (!empty($ans->teacher_file) && \Storage::exists('public/evaluation_files/' . $ans->teacher_file)) {
                    \Storage::delete('public/evaluation_files/' . $ans->teacher_file);
                }

                // Delete admin file
                if (!empty($ans->admin_file) && \Storage::exists('public/evaluation_files/' . $ans->admin_file)) {
                    \Storage::delete('public/evaluation_files/' . $ans->admin_file);
                }

                // Delete answer
                $ans->delete();
            }

            // Delete attempt entry
            $attempt->delete();

            return redirect()->route('admin.results.all')
                ->with('success', 'Attempt deleted successfully!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete attempt: ' . $th->getMessage());
        }
    }

    public function assignTeacherSave(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required|integer',
            'teacher_id' => 'required|integer'
        ]);

        $attempt = StudentTestAttempt::findOrFail($request->attempt_id);
        $attempt->assigned_teacher_id = $request->teacher_id;
        $attempt->save();

        return redirect()
            ->route('admin.results.all')
            ->with('success', 'Teacher assigned successfully.');
    }

}
