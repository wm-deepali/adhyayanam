<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionDetail;
use App\Models\Test;
use App\Models\TestDetail;
use App\Models\StudentTestAttempt;
use App\Models\StudentTestAnswer;
use Illuminate\Http\Request;

class LiveTestController extends Controller
{

    public function liveTest($id)
    {
        $decodeId = base64_decode($id);
        $studentId = auth()->id();

        $test = Test::where('id', $decodeId)->firstOrFail();

        $attempt = StudentTestAttempt::where('student_id', $studentId)
            ->where('test_id', $decodeId)
            ->where('status', 'in_progress')
            ->first();

        if (!$attempt) {
            $attempt = StudentTestAttempt::create([
                'student_id' => $studentId,
                'test_id' => $decodeId,
                'status' => 'in_progress',
                'started_at' => now()
            ]);
        }

        $questionList = TestDetail::where('test_id', $decodeId)
            ->whereNull('parent_question_id')
            ->pluck('question_id')
            ->toArray();

        $questionList = array_values(array_filter($questionList));

        // ========================= ANSWER COUNT =========================
        $answeredQuery = StudentTestAnswer::where('attempt_id', $attempt->id)
            ->whereNull('parent_question_id')
            ->where(function ($q) {
                $q->whereNotNull('answer_text')
                    ->orWhereNotNull('answer_key')
                    ->orWhereNotNull('answer_file');
            });

        $answeredCount = $answeredQuery->count();

        // 👉 Here we fetch Answered Question IDs
        $answeredIds = $answeredQuery->pluck('question_id')->toArray();

        $totalQuestions = count($questionList);
        $pendingCount = $totalQuestions - $answeredCount;

        return view('front.live-test', [
            'test' => $test,
            'question_id_list' => $questionList,
            'attempt_id' => $attempt->id,
            'total_questions' => $totalQuestions,
            'answered_count' => $answeredCount,
            'pending_count' => $pendingCount,
            'answered_ids' => $answeredIds, // 👉 Sending to UI
        ]);
    }

    public function fetchQuestion(Request $request)
    {
        $question = Question::where('id', $request->question_id)
            ->with('questionDeatils')
            ->first();

        if (!$question) {
            return response()->json(['success' => false, 'message' => 'Question not found']);
        }

        $testId = $request->test_id;
        $attemptId = $request->attempt_id;

        $mainMarks = TestDetail::where('test_id', $testId)
            ->where('question_id', $request->question_id)
            ->first();

        $childMarks = [];

        if ($question->question_type === "Story Based") {
            $childIds = $question->questionDeatils->pluck('id')->toArray();

            $childMarks = TestDetail::where('test_id', $testId)
                ->whereIn('question_id', $childIds)
                ->get()
                ->keyBy('question_id');
        }

        // ================== FETCH SAVED DATA ===================
        $savedMainAnswer = StudentTestAnswer::where('attempt_id', $attemptId)
            ->where('question_id', $request->question_id)
            ->whereNull('parent_question_id')
            ->first();

        $savedChildAnswers = [];

        if ($question->question_type === "Story Based") {
            $savedChildAnswers = StudentTestAnswer::where('attempt_id', $attemptId)
                ->where('parent_question_id', $request->question_id)
                ->get()
                ->keyBy('question_id'); // Key by child ID
        }

        return response()->json([
            'success' => true,
            'question' => $question,
            'main_marks' => $mainMarks,
            'child_marks' => $childMarks,
            'saved_main_answer' => $savedMainAnswer,
            'saved_child_answers' => $savedChildAnswers
        ]);
    }

    public function saveAttemptAnswer(Request $request)
    {
        try {

            if (!$request->attempt_id || !$request->question_id) {
                return response()->json(['status' => false, 'msg' => 'Invalid request']);
            }

            $attemptId = $request->attempt_id;

            // ================= FETCH EXISTING MAIN ==================
            $existingMain = StudentTestAnswer::where('attempt_id', $attemptId)
                ->where('question_id', $request->question_id)
                ->whereNull('parent_question_id')
                ->first();

            $previousFile = $existingMain->answer_file ?? null;


            $isAttempted = !empty($request->answer_key)
                || !empty($request->answer_text)
                || $request->hasFile('answer_file')
                || !empty($previousFile);


            // ================= MAIN ANSWER SAVE ===================
            $mainAnswerData = [
                'attempt_id' => $attemptId,
                'question_id' => $request->question_id,
                'parent_question_id' => null,
                'answer_key' => $request->answer_key ?? $existingMain->answer_key ?? null,
                'answer_text' => $request->answer_text ?? $existingMain->answer_text ?? null,
                'answer_file' => $previousFile, // keep old file by default
                'obtained_marks' => null,
                'requires_manual_check' => false,
                'attempt_status' => $isAttempted ? 'attempted' : 'not_attempted',
                'evaluation_status' => 'not_evaluated',
                'answered_at' => now()
            ];

            // If NEW main file uploaded
            if ($request->hasFile('answer_file')) {
                $file = $request->file('answer_file');
                $fileName = uniqid('ans_') . "." . $file->getClientOriginalExtension();
                $file->storeAs('public/student_attempts', $fileName);

                $mainAnswerData['answer_file'] = $fileName;
                $mainAnswerData['requires_manual_check'] = true;
                $mainAnswerData['evaluation_status'] = 'pending';
            }

            $testDetail = TestDetail::where('test_id', $request->test_id)
                ->where('question_id', $request->question_id)
                ->first();

            $mainAnswerData['positive_mark'] = $testDetail->positive_mark ?? 0;
            $mainAnswerData['negative_mark'] = $testDetail->negative_mark ?? 0;

            StudentTestAnswer::updateOrCreate(
                ['attempt_id' => $attemptId, 'question_id' => $request->question_id],
                $mainAnswerData
            );


            // ================== CHILD ANSWERS ======================
            if ($request->child_answers) {

                $childResponses = json_decode($request->child_answers, true);

                $uploadedFiles = $request->child_files ?? [];

                foreach ($childResponses as $index => $child) {

                    $childId = $child['child_id'];

                    $existingChild = StudentTestAnswer::where('attempt_id', $attemptId)
                        ->where('question_id', $childId)
                        ->first();

                    $previousChildFile = $existingChild->answer_file ?? null;
                    $fileName = $previousChildFile;
                    $childAttempted = !empty($previousChildFile);

                    // CHECK IF NEW FILE WAS PASSED
                    if (!empty($uploadedFiles[$index])) {

                        $file = $uploadedFiles[$index];
                        $fileName = uniqid('child_') . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('public/student_attempts', $fileName);

                        $childAttempted = true;
                    }

                    // TEXT or MCQ answered?
                    if (!empty($child['answer_text']) || !empty($child['answer_key'])) {
                        $childAttempted = true;
                    }

                    $testDetailChild = TestDetail::where('test_id', $request->test_id)
                        ->where('question_id', $childId)
                        ->first();

                    StudentTestAnswer::updateOrCreate(
                        [
                            'attempt_id' => $attemptId,
                            'question_id' => $childId
                        ],
                        [
                            'parent_question_id' => $request->question_id,
                            'answer_text' => $child['answer_text'] ?? ($existingChild->answer_text ?? null),
                            'answer_key' => $child['answer_key'] ?? ($existingChild->answer_key ?? null),
                            'answer_file' => $fileName,
                            'obtained_marks' => null,
                            'requires_manual_check' => !empty($fileName),
                            'evaluation_status' => !empty($fileName) ? 'pending' : 'not_evaluated',
                            'attempt_status' => $childAttempted ? 'attempted' : 'not_attempted',
                            'positive_mark' => $testDetailChild->positive_mark ?? 0,
                            'negative_mark' => $testDetailChild->negative_mark ?? 0,
                            'answered_at' => now()
                        ]
                    );
                }

            }

            return response()->json(['status' => true, 'message' => 'Answer saved successfully']);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function finalizeStudentTest(Request $request)
    {
        try {

            if (!$request->attempt_id) {
                return response()->json(['success' => false, 'message' => 'Invalid request']);
            }

            $attempt = StudentTestAttempt::findOrFail($request->attempt_id);
            $testId = $attempt->test_id;
            $remainingTime = $request->remaining_time ?? 0;

            $test = Test::findOrFail($testId);
            $answers = StudentTestAnswer::where('attempt_id', $attempt->id)->get();
            $testDetails = TestDetail::where('test_id', $testId)->get();

            $totalQuestions = $testDetails->where('parent_question_id', null)->count();

            $attemptedParents = [];
            $correctParents = [];
            $wrongParents = [];

            foreach ($answers as $ans) {

                $earnedMarks = 0;

                $parentId = $ans->parent_question_id ?? $ans->question_id;

                $detail = $testDetails->where('question_id', $ans->question_id)->first();
                if (!$detail)
                    continue;

                $isAttempted = $ans->attempt_status === 'attempted';

                if (!$isAttempted) {
                    // Not attempted
                    $ans->update([
                        'evaluation_status' => 'not_evaluated',
                        'obtained_marks' => 0
                    ]);
                    continue;
                }

                // Mark attempt
                $attemptedParents[$parentId] = true;

                // Check if parent or child
                if ($ans->parent_question_id === null) {
                    $question = Question::find($ans->question_id);

                    if ($question->question_type === 'MCQ') {
                        if (strcasecmp($ans->answer_key, trim($question->answer)) === 0) {
                            $earnedMarks = $detail->positive_mark;
                            $correctParents[$parentId] = true;
                            unset($wrongParents[$parentId]);
                            $ans->update([
                                'evaluation_status' => 'correct',
                                'obtained_marks' => $earnedMarks
                            ]);

                        } else {
                            $earnedMarks = -abs($detail->negative_mark);
                            if (!isset($correctParents[$parentId])) {
                                $wrongParents[$parentId] = true;
                            }
                            $ans->update([
                                'evaluation_status' => 'wrong',
                                'obtained_marks' => $earnedMarks
                            ]);
                        }

                    } else {
                        $ans->update([
                            'evaluation_status' => 'pending',
                            'requires_manual_check' => true,
                            'obtained_marks' => null
                        ]);
                    }

                } else {
                    // CHILD EVALUATION
                    $questionDetail = QuestionDetail::find($ans->question_id);

                    if ($questionDetail && !empty($questionDetail->answer)) {

                        // If child is MCQ evaluation
                        if (!empty($questionDetail->answer) && !empty($ans->answer_key)) {

                            if (strcasecmp($ans->answer_key, trim($questionDetail->answer)) === 0) {
                                $earnedMarks = $detail->positive_mark;
                                $correctParents[$parentId] = true;
                                unset($wrongParents[$parentId]);

                                $ans->update([
                                    'evaluation_status' => 'correct',
                                    'obtained_marks' => $earnedMarks
                                ]);
                            } else {
                                $earnedMarks = -abs($detail->negative_mark);
                                if (!isset($correctParents[$parentId]))
                                    $wrongParents[$parentId] = true;

                                $ans->update([
                                    'evaluation_status' => 'wrong',
                                    'obtained_marks' => $earnedMarks
                                ]);
                            }

                        } else {
                            // Subjective or child file uploaded
                            $ans->update([
                                'evaluation_status' => 'pending',
                                'requires_manual_check' => true,
                                'obtained_marks' => null
                            ]);
                        }

                    } else {
                        $ans->update([
                            'evaluation_status' => 'pending',
                            'requires_manual_check' => true,
                            'obtained_marks' => null
                        ]);
                    }
                }
            }

            $mainAnswers = StudentTestAnswer::where('attempt_id', $attempt->id)
                ->whereNull('parent_question_id')
                ->get();

            foreach ($mainAnswers as $main) {

                $children = StudentTestAnswer::where('attempt_id', $attempt->id)
                    ->where('parent_question_id', $main->question_id)
                    ->get();

                if ($children->count() == 0)
                    continue;

                $pending = $children->where('evaluation_status', 'pending')->count();
                $correct = $children->where('evaluation_status', 'correct')->count();
                $attempted = $children->where('attempt_status', 'attempted')->count();

                if ($pending > 0) {
                    $main->update(['evaluation_status' => 'pending']);
                } else if ($correct == count($children)) {
                    $main->update(['evaluation_status' => 'correct']);
                } else if ($correct > 0 && $correct < $attempted) {
                    $main->update(['evaluation_status' => 'partial']);
                } else if ($attempted > 0 && $correct == 0) {
                    $main->update(['evaluation_status' => 'wrong']);
                }
            }


            $correct = count($correctParents);
            $wrong = count($wrongParents);
            $attemptedCount = count($attemptedParents);
            $notAttempted = $totalQuestions - $attemptedCount;

            $earnedPositive = StudentTestAnswer::where('attempt_id', $attempt->id)
                ->where('obtained_marks', '>', 0)
                ->sum('obtained_marks');

            $earnedNegative = StudentTestAnswer::where('attempt_id', $attempt->id)
                ->where('obtained_marks', '<', 0)
                ->sum('obtained_marks');

            $finalScore = $earnedPositive + $earnedNegative;

            $pendingQuestions = StudentTestAnswer::where('attempt_id', $attempt->id)
                ->where('requires_manual_check', true)
                ->count();

            $status = $pendingQuestions > 0 ? "pending" : "published";

            $durationSeconds = $test->duration * 60;
            $timeTaken = $durationSeconds - $remainingTime;

            $attempt->update([
                'total_questions' => $totalQuestions,
                'attempted_count' => $attemptedCount,
                'not_attempted' => $notAttempted,
                'correct_count' => $correct,
                'wrong_count' => $wrong,
                'earned_positive_score' => $earnedPositive,
                'earned_negative_score' => abs($earnedNegative),
                'final_score' => $finalScore,
                'status' => $status,
                'completed_at' => now(),
                'time_taken' => $timeTaken,
                'actual_marks' => $test->total_marks
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test submitted successfully',
                'result_id' => base64_encode($attempt->id)
            ]);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function viewTestResult($id)
    {
        try {
            $attemptId = base64_decode($id);

            $attempt = StudentTestAttempt::with(['student', 'test'])->findOrFail($attemptId);
            $test = Test::findOrFail($attempt->test_id);

            $attemptCount = StudentTestAttempt::where('student_id', auth()->id())
                ->where('test_id', $attempt->test_id)
                ->count();

            $mainAnswers = StudentTestAnswer::with('question')
                ->where('attempt_id', $attemptId)
                ->whereNull('parent_question_id')
                ->get();

            $childAnswers = StudentTestAnswer::with('childQuestion')
                ->where('attempt_id', $attemptId)
                ->whereNotNull('parent_question_id')
                ->get()
                ->groupBy('parent_question_id');

            return view('front.result', [
                'attempt' => $attempt,
                'attemptCount' => $attemptCount,
                'test' => $test,
                'mainAnswers' => $mainAnswers,
                'childGrouped' => $childAnswers
            ]);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Result not found: ' . $th->getMessage());
        }
    }

    public function clearAnswer(Request $request)
    {
        StudentTestAnswer::where('attempt_id', $request->attempt_id)
            ->where('question_id', $request->question_id)
            ->delete();

        StudentTestAnswer::where('attempt_id', $request->attempt_id)
            ->where('parent_question_id', $request->question_id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Answer cleared successfully'
        ]);
    }

}
