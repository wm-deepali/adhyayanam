<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentTestAttempt;
use App\Models\StudentTestAnswer;
use Illuminate\Http\Request;

class TeacherResultController extends Controller
{
    /**
     * Show all tests assigned to this teacher
     */
    public function assigned()
    {
        $teacherId = auth('teacher')->id();

        $attempts = StudentTestAttempt::where('assigned_teacher_id', $teacherId)
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('teachers.results.assigned', compact('attempts'));
    }


    /**
     * Completed evaluations by teacher
     */
    public function completed()
    {
        $teacherId = auth('teacher')->id();

        $attempts = StudentTestAttempt::where('assigned_teacher_id', $teacherId)
            ->where('status', 'under_review') // teacher submitted work
            ->latest()
            ->paginate(20);

        return view('teachers.results.completed', compact('attempts'));
    }


    /**
     * Teacher evaluation page for one attempt
     */
    public function evaluate($id)
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

        return view('teachers.results.evaluate', [
            'attempt' => $attempt,
            'mainAnswers' => $mainAnswers,
            'childGrouped' => $childAnswers,
            'summary' => $summary
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
        $answer->teacher_remarks = $request->remarks ?? null;

        // File upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/evaluation_files', $name);

            $answer->teacher_file = $name;
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


    public function saveEvaluation(Request $request)
    {
        $request->validate([
            'attempt_id' => 'required|integer',
            'final_status' => 'required|string',
            'final_file' => 'nullable|file'
        ]);

        $attempt = StudentTestAttempt::findOrFail($request->attempt_id);

        $attempt->status = $request->final_status;

        // File upload
        if ($request->hasFile('final_file')) {
            $filename = time() . '_' . uniqid() . '.' . $request->final_file->extension();
            $request->final_file->storeAs('public/evaluations', $filename);
            $attempt->final_file = $filename;
        }

        $attempt->save();

        return response()->json([
            'status' => true,
            'msg' => 'Evaluation submitted successfully.',
        ]);
    }



}
