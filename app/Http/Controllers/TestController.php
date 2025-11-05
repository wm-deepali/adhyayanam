<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CallBack;
use App\Models\Career;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\DailyBooster;
use App\Models\Test;
use App\Models\CourseTopic;
use App\Models\TestDetail;
use App\Models\DirectEnquiry;
use App\Models\ExaminationCommission;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\SEO;
use App\Models\StudyMaterial;
use App\Models\SubCategory;
use App\Models\Subject;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use App\Models\Team;
use App\Models\TestPlanner;
use App\Models\TestSeries;
use App\Models\Topic;
use App\Models\UpcomingExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Imports\QuestionsImport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\HeadingRowImport;
use Barryvdh\DomPDF\Facade\Pdf;
class TestController extends Controller
{
    public function testPaperCreate()
    {
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = Subject::get();
        $data['topics'] = Topic::get();
        $data['categories'] = Category::get();
        return view('test-paper.create', $data);
    }

    public function testBankIndex()
    {
        $data['test'] = Test::with('subject', 'topic', 'commission', 'category', 'testDetails')->get();

        return view('test-paper.index', $data);
    }

    public function fetchSubCategoryByExamCategory($category)
    {
        try {
            $category = Category::findOrFail($category);
            $sub_categories = SubCategory::where('category_id', $category->id)->get();
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.exam-child-categories-option')->with([
                    'category' => $category,
                    'sub_categories' => $sub_categories,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function fetchExamCategoryByCommission($commission)
    {
        try {
            $competitive_commission = ExaminationCommission::findOrFail($commission);
            $exam_categories = Category::where('exam_com_id', $competitive_commission->id)->get();
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.exam-category-by-commission-list')->with([
                    'competitive_commission' => $competitive_commission,
                    'exam_categories' => $exam_categories,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function fetchSubjectBySubCategory($subcategory)
    {
        try {
            $subcat = SubCategory::findOrFail($subcategory);
            $subjects = Subject::where('sub_category_id', $subcat->id)->get();
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.subject-by-sub-category')->with([
                    'subcat' => $subcat,
                    'subjects' => $subjects,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function allSubject(Request $request)
    {
        try {

            $subcat = $request->sub_category;
            $comm = ExaminationCommission::findOrFail($request->commission);
            $cat = Category::findOrFail($request->exam_category);

            $subjects = Subject::where('exam_com_id', $comm->id)->where('category_id', $cat->id);
            if (isset($subcat) && $subcat != 0) {

                $subjects = $subjects->where('sub_category_id', $subcat);
            }
            $subjects = $subjects->get();
            //echo "<pre>";print_r($subjects);exit;
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.subject-by-sub-category')->with([
                    //'subcat' => $subcat,
                    'subjects' => $subjects,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function allSubjectMulti(Request $request)
    {
        try {

            $subcat = $request->sub_category;
            $comm = ExaminationCommission::findOrFail($request->commission);
            $cat = Category::findOrFail($request->exam_category);

            $subjects = Subject::where('exam_com_id', $comm->id)->where('category_id', $cat->id);
            if (isset($subcat) && $subcat != 0) {
                $subjects = $subjects->where('sub_category_id', $subcat);
            }
            $subjects = $subjects->get();
            //echo "<pre>";print_r($subjects);exit;
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.subject-by-sub-category-multiselect')->with([
                    //'subcat' => $subcat,
                    'subjects' => $subjects,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }


    public function previewTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'competitive_commission' => 'required',
            'exam_category' => 'required',
            'exam_subcategory' => 'nullable',
            'subject' => 'required',
            'topic' => 'nullable',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
            'name' => 'required|max:255',
            'duration' => 'required|numeric|gt:0',
            'total_questions' => 'required|numeric|gte:0',
            'total_marks' => 'required|numeric|gte:0',
            'test_instruction' => 'required',
            'question_shuffling' => 'required',
            'allow_re_attempt' => 'required',
            'number_of_re_attempt_allowed' => 'required_if:reattempt,yes|gte:0',
            'has_negative_marks' => 'required',
            'negative_marks_per_question' => 'required_if:has_negative_marks,yes|gte:0',

        ]);


        if ($validator->passes()) {
            if ($request->total_questions != $request->selectedquestion) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'errors' => ['total_questions' => ['Total question must be equal to selected question']],
                ]);
            }
            DB::beginTransaction();
            try {
                $previous_year = Null;

                $testData = array(
                    'language' => $request->language == 1 ? 'Hindi' : 'English',
                    'id' => $request->id ?? null,
                    'competitive_commission_id' => $request->competitive_commission,
                    'competitive_commission_name' => ExaminationCommission::find($request->competitive_commission)->name ?? Null,
                    'exam_category_id' => $request->exam_category,
                    'exam_category_name' => Category::find($request->exam_category)->name ?? Null,
                    'topic_id' => $request->topic,
                    'topic_name' => Topic::find($request->topic)->name ?? Null,
                    'subject_id' => $request->subject,
                    'subject_name' => Subject::find($request->subject)->name ?? Null,
                    'paper_type' => $request->paper_type,
                    'previous_year' => $previous_year,
                    'name' => $request->name,
                    'duration' => $request->duration,
                    'total_questions' => $request->total_questions,
                    'total_marks' => $request->total_marks,
                    'test_instruction' => $request->test_instruction,

                    'question_shuffling' => $request->question_shuffling,
                    'allow_re_attempt' => $request->allow_re_attempt,
                    'number_of_re_attempt_allowed' => $request->number_of_re_attempt_allowed,
                    'has_negative_marks' => $request->has_negative_marks,

                    'mcq_total_question' => $request->mcq_total_question,
                    'mcq_mark_per_question' => $request->mcq_mark_per_question,
                    'mcq_total_marks' => $request->mcq_total_marks,
                    'story_total_question' => $request->story_total_question,
                    'story_mark_per_question' => $request->story_mark_per_question,
                    'story_total_marks' => $request->story_total_marks,
                    'subjective_total_question' => $request->subjective_total_question,
                    'subjective_mark_per_question' => $request->subjective_mark_per_question,
                    'subjective_total_marks' => $request->subjective_total_marks,

                    'non_section_details' => json_decode($request->non_section_details, true),

                    'positive_per_question_marks' => $request->positive_per_question_marks,
                    'negative_marks_per_question' => $request->negative_marks_per_question,
                    'question_generated_by' => $request->question_generated_by,
                );

                return response()->json([
                    'success' => true,
                    'testData' => $testData,
                    'html' => view('test-paper.preview-test')->with([
                        'filter_type' => $request->filter_type,
                        'testData' => $testData,
                        'section_details' => json_decode($request->section_details, true)
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage() . '-' . $ex->getLine(),
                ]);
            }
        } else {
            DB::rollback();
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'competitive_commission' => 'required',
            'exam_category' => 'required',
            'exam_subcategory' => 'required',
            'subject' => 'nullable',
            'topic' => 'nullable',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
            'name' => 'required|max:255',
            'duration' => 'required|numeric|gt:0',
            'total_questions' => 'required|numeric|gte:0',
            'total_marks' => 'required|numeric|gte:0',
            'test_instruction' => 'required',
            'question_shuffling' => 'required',
            'allow_re_attempt' => 'required',
            'number_of_re_attempt_allowed' => 'required_if:reattempt,yes|gte:0',
            'has_negative_marks' => 'required',
            'negative_marks_per_question' => 'required_if:has_negative_marks,yes|gte:0',
            'total_positive_marks' => 'required|gte:0',
            'total_negative_marks' => 'required|gte:0',
        ]);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $previous_year = Null;

                $testPaperType = '';
                if ($request->mcq_total_question > 0) {
                    $testPaperType = 'MCQ';
                }
                if ($request->story_total_question > 0) {
                    if ($testPaperType != "") {
                        $testPaperType = 'Combined';
                    } else {
                        $testPaperType = 'Passage';
                    }
                }
                if ($request->subjective_total_question > 0) {
                    if ($testPaperType != "") {
                        $testPaperType = 'Combined';
                    } else {
                        $testPaperType = 'Subjective';
                    }
                }

                $total_marks_mcq = 0;
                $positive_marks_per_question_mcq = 0;
                $negative_marks_per_question_mcq = 0;

                foreach (json_decode($request->question_marks_details) as $dt) {
                    // Ignore sub-questions (only process main ones)
                    if (!empty($dt->sub_question_id)) {
                        continue;
                    }

                    $positive = $dt->positive_mark ?? 0;
                    $negative = $dt->negative_mark ?? 0;

                    $total_marks_mcq += $positive;
                    $positive_marks_per_question_mcq = $positive;
                    $negative_marks_per_question_mcq = $negative;
                }

                $testData = array(
                    'language' => $request->language,

                    'competitive_commission_id' => $request->competitive_commission,
                    'exam_category_id' => $request->exam_category,
                    'exam_subcategory_id' => $request->exam_subcategory,
                    'topic_id' => $request->topic,
                    'subject_id' => $request->subject,
                    'test_type' => $request->test_type,
                    'chapter_id' => $request->chapter_id,
                    'paper_type' => $request->paper_type,
                    'previous_year' => $request->paper_type == 0 ? NULL : $request->previous_year,
                    'name' => $request->name,
                    'duration' => $request->duration,

                    'total_questions' => $request->total_questions,
                    'total_marks' => $request->total_marks,

                    'test_instruction' => $request->test_instruction,

                    'question_shuffling' => $request->question_shuffling,
                    'allow_re_attempt' => $request->allow_re_attempt,
                    'number_of_re_attempt_allowed' => $request->number_of_re_attempt_allowed,
                    'has_negative_marks' => $request->has_negative_marks,


                    'non_section_details' => $request->non_section_details,

                    'question_marks_details' => $request->question_marks_details,
                    'total_positive_marks' => $request->total_positive_marks,
                    'total_negative_marks' => $request->total_negative_marks,


                    'positive_marks_per_question' => $positive_marks_per_question_mcq,
                    'negative_marks_per_question' => $negative_marks_per_question_mcq,

                    'mcq_total_question' => $request->mcq_total_question,
                    'mcq_mark_per_question' => $request->mcq_mark_per_question,
                    'mcq_total_marks' => $request->mcq_total_marks,
                    'story_total_question' => $request->story_total_question,
                    'story_mark_per_question' => $request->story_mark_per_question,
                    'story_total_marks' => $request->story_total_marks,
                    'subjective_total_question' => $request->subjective_total_question,
                    'subjective_mark_per_question' => $request->subjective_mark_per_question,
                    'subjective_total_marks' => $request->subjective_total_marks,
                    'test_paper_type' => $testPaperType,
                    'question_generated_by' => $request->question_generated_by ?? 'manual',
                );
                //echo "<pre>";print_r($testData);exit;
                $test = Test::create($testData);
                // print_r((json_decode($request->section_details,true)));
                $datajson = json_decode($request->non_section_details, true);


                $lastParentQuestionId = null;

                foreach (json_decode($request->question_marks_details) as $dt) {
                    $type = $dt->test_question_type ?? '';

                    // ✅ For Passage (main question)
                    if ($type === 'Passage') {
                        TestDetail::create([
                            'test_id' => $test->id,
                            'question_id' => (int) $dt->question_id,
                            'parent_question_id' => null,
                            'positive_mark' => (float) ($dt->positive_mark ?? 0),
                            'negative_mark' => (float) ($dt->negative_mark ?? 0),
                        ]);

                        // Remember this Passage as parent for next sub-questions
                        $lastParentQuestionId = $dt->question_id;
                        continue;
                    }

                    // ✅ For Sub Passage (child question)
                    if ($type === 'Sub Passage') {
                        TestDetail::create([
                            'test_id' => $test->id,
                            'question_id' => (int) $dt->sub_question_id,
                            'parent_question_id' => (int) $lastParentQuestionId,
                            'positive_mark' => (float) ($dt->sub_positive_mark ?? 0),
                            'negative_mark' => (float) ($dt->sub_negative_mark ?? 0),
                        ]);
                        continue;
                    }

                    // ✅ For all other question types (MCQ, Subjective, etc.)
                    TestDetail::create([
                        'test_id' => $test->id,
                        'question_id' => (int) $dt->question_id,
                        'parent_question_id' => null,
                        'positive_mark' => (float) ($dt->positive_mark ?? 0),
                        'negative_mark' => (float) ($dt->negative_mark ?? 0),
                    ]);
                }

                $test->update([
                    'test_code' => 'TEST-' . $test->id,
                ]);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msgText' => 'Test Created !',
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage() . '-' . $ex->getLine(),
                ]);
            }
        } else {
            DB::rollback();
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'competitive_commission' => 'required',
            'exam_category' => 'required',
            'exam_subcategory' => 'nullable',
            'subject' => 'nullable',
            'topic' => 'nullable',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
            'name' => 'required|max:255',
            'duration' => 'required|numeric|gt:0',
            'total_questions' => 'required|numeric|gte:0',
            'total_marks' => 'required|numeric|gte:0',
            'test_instruction' => 'required',
            'question_shuffling' => 'required',
            'allow_re_attempt' => 'required',
            'number_of_re_attempt_allowed' => 'required_if:reattempt,yes|gte:0',
            'has_negative_marks' => 'required',
            'negative_marks_per_question' => 'required_if:has_negative_marks,yes|gte:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();

        try {
            $test = Test::findOrFail($id);

            // --- Determine paper type ---
            $testPaperType = '';
            if ($request->mcq_total_question > 0)
                $testPaperType = 'MCQ';
            if ($request->story_total_question > 0)
                $testPaperType = $testPaperType ? 'Combined' : 'Passage';
            if ($request->subjective_total_question > 0)
                $testPaperType = $testPaperType ? 'Combined' : 'Subjective';

            // --- Calculate marks summary ---
            $total_marks_mcq = 0;
            $positive_marks_per_question_mcq = 0;
            $negative_marks_per_question_mcq = 0;

            $questionMarks = json_decode($request->question_marks_details);

            foreach ($questionMarks as $dt) {
                // Ignore sub-questions (only process main ones)
                if (!empty($dt->sub_question_id)) {
                    continue;
                }

                $positive = $dt->positive_mark ?? 0;
                $negative = $dt->negative_mark ?? 0;

                $total_marks_mcq += $positive;
                $positive_marks_per_question_mcq = $positive;
                $negative_marks_per_question_mcq = $negative;
            }
            // --- Prepare test data ---
            $testData = [
                'language' => $request->language,
                'competitive_commission_id' => $request->competitive_commission,
                'exam_category_id' => $request->exam_category,
                'exam_subcategory_id' => $request->exam_subcategory,
                'topic_id' => $request->topic,
                'subject_id' => $request->subject,
                'test_type' => $request->test_type,
                'chapter_id' => $request->chapter_id,
                'paper_type' => $request->paper_type,
                'previous_year' => $request->paper_type == 0 ? null : $request->previous_year,
                'name' => $request->name,
                'duration' => $request->duration,
                'total_questions' => $request->total_questions,
                'total_marks' => $request->total_marks,
                'test_instruction' => $request->test_instruction,
                'question_shuffling' => $request->question_shuffling,
                'allow_re_attempt' => $request->allow_re_attempt,
                'number_of_re_attempt_allowed' => $request->number_of_re_attempt_allowed,
                'has_negative_marks' => $request->has_negative_marks,
                'non_section_details' => $request->non_section_details,
                'question_marks_details' => $request->question_marks_details,
                'total_positive_marks' => $request->total_positive_marks,
                'total_negative_marks' => $request->total_negative_marks,
                'positive_marks_per_question' => $positive_marks_per_question_mcq,
                'negative_marks_per_question' => $negative_marks_per_question_mcq,
                'mcq_total_question' => $request->mcq_total_question,
                'mcq_mark_per_question' => $request->mcq_mark_per_question,
                'mcq_total_marks' => $request->mcq_total_marks,
                'story_total_question' => $request->story_total_question,
                'story_mark_per_question' => $request->story_mark_per_question,
                'story_total_marks' => $request->story_total_marks,
                'subjective_total_question' => $request->subjective_total_question,
                'subjective_mark_per_question' => $request->subjective_mark_per_question,
                'subjective_total_marks' => $request->subjective_total_marks,
                'test_paper_type' => $testPaperType,
            ];

            $test->update($testData);
            // --- Update or insert TestDetail ---
            $last_parent_id = null;

            foreach ($questionMarks as $dt) {
                $question_id = null;
                $parent_question_id = null;

                // Identify question id
                if (!empty($dt->question_id)) {
                    $question_id = (int) $dt->question_id;

                    // store last Passage id only if type is Passage
                    if (isset($dt->test_question_type) && $dt->test_question_type === 'Passage') {
                        $last_parent_id = $question_id;
                    }

                } elseif (!empty($dt->sub_question_id)) {
                    $question_id = (int) $dt->sub_question_id;

                    // assign parent id only if this is a Sub Passage
                    if (isset($dt->test_question_type) && $dt->test_question_type === 'Sub Passage') {
                        $parent_question_id = $last_parent_id;
                    }
                } else {
                    continue; // skip invalid entries
                }

                // determine marks
                $positive_mark = 0;
                $negative_mark = 0;

                if (isset($dt->positive_mark) || isset($dt->negative_mark)) {
                    $positive_mark = (float) ($dt->positive_mark ?? 0);
                    $negative_mark = (float) ($dt->negative_mark ?? 0);
                } elseif (isset($dt->sub_positive_mark) || isset($dt->sub_negative_mark)) {
                    $positive_mark = (float) ($dt->sub_positive_mark ?? 0);
                    $negative_mark = (float) ($dt->sub_negative_mark ?? 0);
                }

                $positive_mark = round($positive_mark, 2);
                $negative_mark = round($negative_mark, 2);

                TestDetail::updateOrCreate(
                    [
                        'test_id' => $test->id,
                        'question_id' => $question_id,
                    ],
                    [
                        'parent_question_id' => $parent_question_id,
                        'positive_mark' => $positive_mark,
                        'negative_mark' => $negative_mark,
                    ]
                );
            }



            DB::commit();

            return response()->json([
                'success' => true,
                'msgText' => 'Test Updated Successfully!',
            ]);

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'msgText' => $ex->getMessage() . ' - Line: ' . $ex->getLine(),
            ]);
        }
    }


    public function view($id)
    {
        try {
            $paper = Test::with('category', 'subcategory', 'commission', 'subject', 'topic', 'chapter')->findOrFail($id);
            $data['paper'] = $paper;
            return view('test-paper.view-test-paper', $data);
        } catch (\Exception $ex) {
            return redirect(route('test-paper.view-test-paper'))->with('error', 'Error Encountered ' . $ex->getMessage());
        }
    }

    public function download($id)
    {
        $paper = Test::with('category', 'subcategory', 'commission', 'subject', 'topic', 'chapter', 'testDetails.question')->findOrFail($id);
        $data['paper'] = $paper;
        $pdf = PDF::loadView('test-paper.pdf-view', $data);
        // dd($$paper->name . '.pdf');
        return $pdf->download($paper->name . '.pdf');
    }

    public function edit($id)
    {
        try {
            $paper = Test::with('category', 'subcategory', 'commission', 'subject', 'topic', 'chapter')->findOrFail($id);
            $data['paper'] = $paper;

            $data['commissions'] = ExaminationCommission::get();

            if ($paper->competitive_commission_id != "") {
                $data['categories'] = Category::where('exam_com_id', $paper->competitive_commission_id)->get();
            } else {
                $data['categories'] = [];
            }

            if ($paper->exam_category_id != "") {
                $data['subcategories'] = SubCategory::where('category_id', $paper->exam_category_id)->get();
            } else {
                $data['subcategories'] = [];
            }

            if ($paper->exam_subcategory_id != "") {
                $data['subjects'] = Subject::where('sub_category_id', $paper->exam_subcategory_id)->get();
            } else {
                $data['subjects'] = [];
            }

            if ($paper->subject_id != "") {
                $data['chapters'] = Chapter::where('subject_id', $paper->subject_id)->get();
            } else {
                $data['chapters'] = [];
            }

            if ($paper->chapter_id != "") {
                $data['topics'] = CourseTopic::where('chapter_id', $paper->chapter_id)->get();
            } else {
                $data['topics'] = [];
            }
            return view('test-paper.edit', $data);
        } catch (\Exception $ex) {
            return redirect(route('test-paper.edit'))->with('error', 'Error Encountered ' . $ex->getMessage());
        }
    }



    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $test = Test::findOrFail($id);
            $test_package_ids = TestDetail::where('test_id', $test->id)->delete();
            // TestPackage::whereIn('id',$test_package_ids)->update([
            //     'status' => 'block',
            //     'disabled' => 'yes',
            // ]);
            // $test_series_ids = TestSeriesDetail::where('test_id',$test->id)->pluck('test_series_id')->toArray();
            // TestSeries::whereIn('id',$test_series_ids)->update([
            //     'status' => 'block',
            //     'disabled' => 'yes',
            // ]);
            // TestSeriesDetail::where('test_id',$test->id)->delete();
            // TestPackageDetail::where('test_id',$test->id)->delete();
            // TestDetail::where('test_id',$test->id)->delete();
            $test->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Test deleted successfully.');
            // return response()->json([
            //     'success' => true,
            //     'name' => $test->name
            // ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('success', 'Something went wrong.');
            // return response()->json([
            //     'success' => false,
            //     'msgText' => $ex->getMessage(),
            // ]);
        }
    }


    public function appendTestSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_level' => 'required',
            'language' => 'required',
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
            'competitive_commission' => 'required_if:exam_type,category_wise',
            'exam_category' => 'required_if:exam_type,category_wise',
            'competitive_topic' => 'required_if:exam_type,category_wise',
            'subject' => 'required_if:exam_type,board_wise|required_if:exam_type,course_wise',
            'paper_type' => 'required',
            'previous_year' => 'required_if:paper_type,previous_year',
            'master_question_item_count' => 'required|gte:0',
        ]);
        if ($validator->passes()) {
            try {
                $master_question_item_count = $request->master_question_item_count;
                $paper_type = $request->paper_type;
                $previous_year = array_values(array_filter(explode(',', $request->previous_year)));
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } elseif ($request->exam_type == 'board_wise') {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } else {
                    $competitive_commission_id = $request->competitive_commission;
                    $exam_category = ExamCategory::findOrFail($request->exam_category);
                    $competitive_topic_ids = array_values(array_filter(explode(',', $request->competitive_topic)));
                    $competitive_topics = CompetitiveTopic::whereIn('id', $competitive_topic_ids)->get();
                    $allChilds = array();
                    foreach ($competitive_topics as $competitive_topic) {
                        $allChilds[] = $competitive_topic->getAllChildren()->pluck('id')->toArray();
                        $allChilds = Arr::prepend($allChilds, $competitive_topic->id);
                    }
                    $all_competitive_topic_ids = array_unique(Arr::flatten($allChilds));

                    $mcq_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'multiple_answer')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'digit_numeric')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'passage')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('language', $request->language)
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'true_false')
                        ->where('language', $request->language)
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'fill_in_the_blank')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                }
                return response()->json([
                    'success' => true,
                    'html' => view('admin.test.ajax.test-section')->with([
                        'mcq_questions_count' => $mcq_questions->count(),
                        'mca_questions_count' => $mca_questions->count(),
                        'digit_numeric_questions_count' => $digit_numeric_questions->count(),
                        'passage_questions_count' => $passage_questions->count(),
                        'reasoning_questions_count' => $reasoningsubjective_questions->count(),
                        'truefalse_questions_count' => $truefalse_questions->count(),
                        'fill_in_the_blank_questions_count' => $fill_in_the_blank_questions->count(),
                        'paper_type' => $paper_type,
                        'previous_years' => Arr::sort($previous_year),
                        'master_question_item_count' => (int) $master_question_item_count + 1,
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function appendTestMasterQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_level' => 'required',
            'language' => 'required',
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
            'competitive_commission' => 'required_if:exam_type,category_wise',
            'exam_category' => 'required_if:exam_type,category_wise',
            'competitive_topic' => 'required_if:exam_type,category_wise',
            'subject' => 'required_if:exam_type,board_wise|required_if:exam_type,course_wise',
            'paper_type' => 'required',
            'previous_year' => 'required_if:paper_type,previous_year',
            'master_question_item_count' => 'required|gte:0',
        ]);
        if ($validator->passes()) {
            try {
                $master_question_item_count = $request->master_question_item_count;
                $paper_type = $request->paper_type;
                $previous_year = array_values(array_filter(explode(',', $request->previous_year)));
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } elseif ($request->exam_type == 'board_wise') {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } else {
                    $competitive_commission_id = $request->competitive_commission;
                    $exam_category = ExamCategory::findOrFail($request->exam_category);
                    $competitive_topic_ids = array_values(array_filter(explode(',', $request->competitive_topic)));
                    $competitive_topics = CompetitiveTopic::whereIn('id', $competitive_topic_ids)->get();
                    $allChilds = array();
                    foreach ($competitive_topics as $competitive_topic) {
                        $allChilds[] = $competitive_topic->getAllChildren()->pluck('id')->toArray();
                        $allChilds = Arr::prepend($allChilds, $competitive_topic->id);
                    }
                    $all_competitive_topic_ids = array_unique(Arr::flatten($allChilds));

                    $mcq_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'multiple_choice')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'multiple_answer')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'digit_numeric')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'passage')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'reasoning_subjective')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'true_false')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'fill_in_the_blank')
                        ->whereNotIn('id', explode(",", $request->question_ids))
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                }
                return response()->json([
                    'success' => true,
                    'html' => view('admin.test.ajax.test-master-question')->with([
                        'mcq_questions_count' => $mcq_questions->count(),
                        'mca_questions_count' => $mca_questions->count(),
                        'digit_numeric_questions_count' => $digit_numeric_questions->count(),
                        'passage_questions_count' => $passage_questions->count(),
                        'reasoning_questions_count' => $reasoningsubjective_questions->count(),
                        'truefalse_questions_count' => $truefalse_questions->count(),
                        'fill_in_the_blank_questions_count' => $fill_in_the_blank_questions->count(),
                        'paper_type' => $paper_type,
                        'previous_years' => Arr::sort($previous_year),
                        'master_question_item_count' => (int) $master_question_item_count + 1,
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function fetchtopicbycourse(Request $request)
    {
        if ($request->filled('id')) {
            try {
                $topic = Topic::where("course_id", $request->id)->where('disabled', 'no')->get();
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.topicoptions')->with('topics', $topic)->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '400',
                'msgText' => 'No Course Selected',
            ]);
        }
    }

    public function fetchquestionbysubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'testlevel' => 'required',
            'subject' => 'required',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
        ]);
        if ($validator->passes()) {
            try {
                $paper_type = $request->paper_type;
                $previous_year = $request->previous_year;
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $question = Question::where("course_id", $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $request->subject)
                        ->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->where('year', $previous_year);
                        })->get();
                    $subject = Subject::where('course_id', $course->id)->where('semester_id', $semester->id)->where('id', $request->subject)->where('disabled', 'no')->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $question = Question::where("board_id", $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $request->subject)
                        ->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->where('year', $previous_year);
                        })->get();
                    $subject = Subject::where('board_id', $board->id)->where('grade_id', $grade->id)->where('id', $request->subject)->where('disabled', 'no')->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with('questions', $question)->render(),
                    'subjectoptions' => view('admin.ajax.subjectoptions')->with('subjects', $subject)->render()
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchquestionbysubjectfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'testlevel' => 'required',
            'question' => 'nullable|array',
            'subject' => 'nullable|integer',
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $question = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->when($request->question, function ($query2, $questionids) {
                            return $query2->whereNotIn('id', $questionids);
                        })->when($request->subject, function ($query1, $id) {
                            return $query1->where('subject_id', $id);
                        })->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $question = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->when($request->question, function ($query2, $questionids) {
                            return $query2->whereNotIn('id', $questionids);
                        })->when($request->subject, function ($query1, $id) {
                            return $query1->where('subject_id', $id);
                        })->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with('questions', $question)->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchquestionbytopicfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'testlevel' => 'required',
            'topic' => 'nullable|integer',
            'question' => 'nullable|array',
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $question = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->when($request->question, function ($query2, $questionids) {
                            return $query2->whereNotIn('id', $questionids);
                        })->when($request->topic, function ($query1, $id) {
                            return $query1->where('topic_id', $id);
                        })->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $question = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->when($request->question, function ($query2, $questionids) {
                            return $query2->whereNotIn('id', $questionids);
                        })->when($request->topic, function ($query1, $id) {
                            return $query1->where('topic_id', $id);
                        })->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with('questions', $question)->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchquestionbytopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'testlevel' => 'required',
            'topic' => 'required',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
        ]);
        if ($validator->passes()) {
            try {
                $paper_type = $request->paper_type;
                $previous_year = $request->previous_year;
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $question = Question::where("course_id", $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('topic_id', $request->topic)
                        ->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->where('year', $previous_year);
                        })->get();
                    $topic = Topic::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('id', $request->topic)
                        ->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $question = Question::where("board_id", $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('topic_id', $request->topic)
                        ->where('questionlanguage', $request->testlanguage)
                        ->where('test_level_id', $request->testlevel)
                        ->where('disabled', 'no')
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->where('year', $previous_year);
                        })->get();
                    $topic = Topic::where("board_id", $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('id', $request->topic)
                        ->where('disabled', 'no')
                        ->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with('questions', $question)->render(),
                    'topicoptions' => view('admin.ajax.topicoptions')->with('topics', $topic)->render()
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchsubjectnamebysubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'subject' => 'required'
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subject = Subject::where('id', $request->subject)->where('course_id', $course->id)->where('semester_id', $semester->id)->where('disabled', 'no')->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subject = Subject::where('id', $request->subject)->where('board_id', $board->id)->where('grade_id', $grade->id)->where('disabled', 'no')->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.randomsubjectquestionoptions')->with('subjects', $subject)->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchtopicnamebytopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_with:board',
            'testlanguage' => 'required',
            'topic' => 'required'
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $topic = Topic::where('id', $request->topic)->where('course_id', $course->id)->where('semester_id', $semester->id)->where('disabled', 'no')->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $topic = Topic::where('id', $request->topic)->where('board_id', $board->id)->where('grade_id', $grade->id)->where('disabled', 'no')->get();
                }
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.randomtopicquestionoptions')->with('topics', $topic)->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchquestionbyexamcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'testlanguage' => 'required',
            'exam_category' => 'required',
            'testlevel' => 'required',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
        ]);
        if ($validator->passes()) {
            try {
                $paper_type = $request->paper_type;
                $previous_year = $request->previous_year;
                $exam_category = ExamCategory::findOrFail($request->exam_category);
                $allchilds[] = $exam_category->getAllChildren()->pluck('id')->toArray();
                $allchilds = Arr::prepend($allchilds, $exam_category->id);
                $allchildcategories = Arr::flatten($allchilds);
                $questions = Question::whereIn("exam_category_id", $allchildcategories)
                    ->where('questionlanguage', $request->testlanguage)
                    ->where('test_level_id', $request->testlevel)
                    ->where('disabled', 'no')
                    ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                        return $query->where('has_year', 'yes')->where('year', $previous_year);
                    })->get();
                $years = array_filter(array_unique($questions->pluck('year')->toArray()));
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with([
                        'questions' => $questions
                    ])->render(),
                    'years' => view('admin.ajax.year-options')->with([
                        'years' => $years
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchTestPreviousYearsByExamType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
            'subject' => 'required_if:exam_type,board_wise|required_if:exam_type,course_wise',
            'exam_category' => 'required_if:exam_type,category_wise',
            'competitive_topic' => 'required_if:exam_type,category_wise',
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subject = Subject::findOrFail($request->subject);
                    $all_prev_year_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('has_year', 'yes')
                        ->pluck('year')
                        ->toArray();
                } elseif ($request->exam_type == 'board_wise') {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subject = Subject::findOrFail($request->subject);
                    $all_prev_year_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('has_year', 'yes')
                        ->pluck('year')
                        ->toArray();
                } else {
                    $exam_category = ExamCategory::findOrFail($request->exam_category);
                    $competitive_topic_ids = array_values(array_filter(explode(',', $request->competitive_topic)));
                    $competitive_topics = CompetitiveTopic::whereIn('id', $competitive_topic_ids)->get();
                    $allChilds = array();
                    foreach ($competitive_topics as $competitive_topic) {
                        $allChilds[] = $competitive_topic->getAllChildren()->pluck('id')->toArray();
                        $allChilds = Arr::prepend($allChilds, $competitive_topic->id);
                    }
                    $all_competitive_topic_ids = array_unique(Arr::flatten($allChilds));
                    $all_prev_year_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('has_year', 'yes')
                        ->pluck('year')
                        ->toArray();
                }
                $all_prev_years = array_unique($all_prev_year_questions);
                return response()->json([
                    "success" => true,
                    "html" => view('admin.ajax.previous-year-options')->with([
                        'all_prev_years' => $all_prev_years,
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function fetchQuestionTypeCountBySelection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_level' => 'required',
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
            'competitive_commission' => 'required_if:exam_type,category_wise',
            'exam_category' => 'required_if:exam_type,category_wise',
            'competitive_topic' => 'required_if:exam_type,category_wise',
            'subject' => 'required_if:exam_type,board_wise|required_if:exam_type,course_wise',
            'paper_type' => 'required',
            'previous_year' => 'required_if:paper_type,previous_year',
        ]);
        if ($validator->passes()) {
            try {
                $paper_type = $request->paper_type;
                $previous_year = array_values(array_filter(explode(',', $request->previous_year)));
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();

                    $truefalse_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('course_id', $course->id)
                        ->where('semester_id', $semester->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } elseif ($request->exam_type == 'board_wise') {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subject = Subject::findOrFail($request->subject);
                    $mcq_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'multiple_answer')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'digit_numeric')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'passage')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::where('board_id', $board->id)
                        ->where('grade_id', $grade->id)
                        ->where('subject_id', $subject->id)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                } else {
                    $competitive_commission_id = $request->competitive_commission;
                    $exam_category = ExamCategory::findOrFail($request->exam_category);
                    $competitive_topic_ids = array_values(array_filter(explode(',', $request->competitive_topic)));
                    $competitive_topics = CompetitiveTopic::whereIn('id', $competitive_topic_ids)->get();
                    $allChilds = array();
                    foreach ($competitive_topics as $competitive_topic) {
                        $allChilds[] = $competitive_topic->getAllChildren()->pluck('id')->toArray();
                        $allChilds = Arr::prepend($allChilds, $competitive_topic->id);
                    }
                    $all_competitive_topic_ids = array_unique(Arr::flatten($allChilds));

                    $mcq_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'multiple_choice')
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $mca_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'multiple_answer')
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $digit_numeric_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'digit_numeric')
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $passage_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'passage')
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $reasoningsubjective_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'reasoning_subjective')
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $truefalse_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'true_false')
                        ->where('test_level_id', $request->test_level)
                        ->where('language', $request->language)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                    $fill_in_the_blank_questions = Question::whereIn('competitive_topic_id', $all_competitive_topic_ids)
                        ->where('question_type', 'fill_in_the_blank')
                        ->where('language', $request->language)
                        ->where('test_level_id', $request->test_level)
                        ->when($paper_type == 'normal', function ($query) {
                            return $query->where('has_year', 'no');
                        })
                        ->when($paper_type == 'previous_year', function ($query) use ($previous_year) {
                            return $query->where('has_year', 'yes')->whereIn('year', $previous_year);
                        })->get();
                }
                return response()->json([
                    "success" => true,
                    'mcq_questions' => $mcq_questions->count(),
                    'mca_questions' => $mca_questions->count(),
                    'digit_numeric_questions' => $digit_numeric_questions->count(),
                    'passage_questions' => $passage_questions->count(),
                    'reasoning_questions' => $reasoningsubjective_questions->count(),
                    'truefalse_questions' => $truefalse_questions->count(),
                    'fill_in_the_blank_questions' => $fill_in_the_blank_questions->count(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function fetchquestionbyyearfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'nullable',
            'exam_type' => 'required',
            'testlanguage' => 'required',
            'testlevel' => 'required',
            'exam_category' => 'required',
        ]);
        if ($validator->passes()) {
            try {
                $exam_category = ExamCategory::findOrFail($request->exam_category);
                $allchilds[] = $exam_category->getAllChildren()->pluck('id')->toArray();
                $allchilds = Arr::prepend($allchilds, $exam_category->id);
                $allchildcategories = Arr::flatten($allchilds);
                $questions = Question::when($request->year, function ($query, $year) {
                    $query->where('year', $year);
                })->whereIn("exam_category_id", $allchildcategories)
                    ->where('questionlanguage', $request->testlanguage)
                    ->where('test_level_id', $request->testlevel)
                    ->where('disabled', 'no')
                    ->get();
                return response()->json([
                    'msgCode' => '200',
                    'html' => view('admin.ajax.questionoptions')->with([
                        'questions' => $questions
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'msgCode' => '400',
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'msgCode' => '401',
                'msgText' => $validator->errors()->all(),
            ]);
        }
    }

    public function fetchtestsubjectsbyexamtype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $subjects = Subject::where('course_id', $course->id)->where('semester_id', $semester->id)->where('disabled', 'no')->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $subjects = Subject::where('board_id', $board->id)->where('grade_id', $grade->id)->where('disabled', 'no')->get();
                }
                return response()->json([
                    "success" => true,
                    "html" => view('admin.ajax.subject-options')->with([
                        'subjects' => $subjects,
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function fetchtesttopicsbyexamtype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type' => 'required',
            'course' => 'required_if:exam_type,course_wise',
            'semester' => 'required_if:exam_type,course_wise',
            'board' => 'required_if:exam_type,board_wise',
            'grade' => 'required_if:exam_type,board_wise',
        ]);
        if ($validator->passes()) {
            try {
                if ($request->exam_type == 'course_wise') {
                    $course = Course::findOrFail($request->course);
                    $semester = Semester::findOrFail($request->semester);
                    $topics = Topic::where('course_id', $course->id)->where('semester_id', $semester->id)->where('disabled', 'no')->get();
                } else {
                    $board = Board::findOrFail($request->board);
                    $grade = Grade::findOrFail($request->grade);
                    $topics = Topic::where('board_id', $board->id)->where('grade_id', $grade->id)->where('disabled', 'no')->get();
                }
                return response()->json([
                    "success" => true,
                    "html" => view('admin.ajax.topic-options')->with([
                        'topics' => $topics,
                    ])->render(),
                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function viewTestDetail($id)
    {
        try {
            $test = Test::findOrFail($id);
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.view-test-detail')->with([
                    'test' => $test,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function generatetestquestionsbyselections(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_generated_by' => 'required',
            'language' => 'required',
            'subject' => 'required',
            'topic' => 'nullable',
            'competitive_commission' => 'required',
            'exam_category' => 'required',
            'exam_subcategory' => 'required',
            'total_questions' => 'required',
            'test_type' => 'required',
            'mcq_question_total' => 'required',
            'story_question_total' => 'required',
            'subjective_question_total' => 'required',
            'paper_type' => 'required',
            'previous_year' => 'nullable|required_if:paper_type,previous_year',
        ]);
        if ($validator->passes()) {
            try {
                $question_generated_by = $request->question_generated_by;
                $language = $request->language;
                $category_id = $request->exam_category;
                $sub_category_id = $request->exam_subcategory;
                $paper_type = $request->paper_type;
                $previous_year = $request->previous_year;
                $commission_id = $request->competitive_commission;
                $question_count = $request->total_questions;

                $mcq_question_total = $request->mcq_question_total;
                $story_question_total = $request->story_question_total;
                $subjective_question_total = $request->subjective_question_total;
                $test_type = ucfirst($request->test_type);

                $subject = $request->subject ?? NULL;
                $topic = $request->topic ?? NULL;
                $chapter_id = $request->chapter_id ?? NULL;


                if ($question_generated_by == 'manual') {
                    $mcqquestions = Question::where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'MCQ')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        ->where('fee_type', $test_type)
                        ->where('sub_category_id', $sub_category_id)
                        ->where('question_category', $paper_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })

                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($mcq_question_total)
                        ->get();

                    $storyquestions = Question::with('questionDeatils')->where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'Story Based')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        //->where('sub_category_id',$sub_category_id)
                        ->where('question_category', $paper_type)
                        ->where('fee_type', $test_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })
                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($story_question_total)
                        ->get();

                    $subjectivequestions = Question::where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'Subjective')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        //->where('sub_category_id',$sub_category_id)
                        ->where('question_category', $paper_type)
                        ->where('fee_type', $test_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })
                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($subjective_question_total)
                        ->get();

                    return response()->json([
                        'success' => true,
                        'mcq_html' => view('admin.ajax.questionoptions')->with('questions', $mcqquestions)->render(),
                        'story_html' => view('admin.ajax.questionoptions')->with('questions', $storyquestions)->render(),
                        'subjective_html' => view('admin.ajax.questionoptions')->with('questions', $subjectivequestions)->render(),
                        'mcq_questions_count' => $mcqquestions->count(),
                        'story_questions_count' => $storyquestions->count(),
                        'subjective_questions_count' => $subjectivequestions->count(),
                    ]);
                } else {
                    $mcqquestions = Question::where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'MCQ')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        //->where('sub_category_id',$sub_category_id)
                        ->where('question_category', $paper_type)

                        ->where('fee_type', $test_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })
                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($mcq_question_total)
                        ->inRandomOrder()
                        ->get();

                    $storyquestions = Question::with('questionDeatils')->where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'Story Based')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        //->where('sub_category_id',$sub_category_id)
                        ->where('question_category', $paper_type)
                        ->where('fee_type', $test_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })
                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($story_question_total)
                        ->inRandomOrder()
                        ->get();

                    $subjectivequestions = Question::where('commission_id', $commission_id)
                        ->where('subject_id', $request->subject)
                        ->where('question_type', 'Subjective')
                        ->where('language', $language)
                        ->where('category_id', $category_id)
                        //->where('sub_category_id',$sub_category_id)
                        ->where('question_category', $paper_type)
                        ->where('fee_type', $test_type)
                        ->when($chapter_id, function ($query, $chapter_id) {
                            return $query->where('chapter_id', $chapter_id);
                        })
                        ->when($topic, function ($query, $topic) {
                            return $query->where('topic', $topic);
                        })
                        // ->when($paper_type == 1,function($query) use($previous_year){
                        //     return $query->where('previous_year', $previous_year);
                        // })
                        ->limit($subjective_question_total)
                        ->inRandomOrder()
                        ->get();
                    return response()->json([
                        'success' => true,
                        'mcq_html' => view('admin.ajax.questionoptions')->with('questions', $mcqquestions)->render(),
                        'story_html' => view('admin.ajax.questionoptions')->with('questions', $storyquestions)->render(),
                        'subjective_html' => view('admin.ajax.questionoptions')->with('questions', $subjectivequestions)->render(),
                        'mcq_questions_count' => $mcqquestions->count(),
                        'story_questions_count' => $storyquestions->count(),
                        'subjective_questions_count' => $subjectivequestions->count(),
                    ]);

                }

            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function generatetestpaperbyselections(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_generated_by' => 'required',
            'language' => 'required',
            'fee_type' => 'required',
            'competitive_commission' => 'required',
            'exam_category' => 'required',
            'total_paper' => 'required',
            'test_type' => 'required',
        ]);
        if ($validator->passes()) {
            try {
                $test_generated_by = $request->test_generated_by;
                $language = $request->language;
                $fee_type = $request->fee_type;
                $category_id = $request->exam_category;
                $paper_type = $request->test_type;
                $commission_id = $request->competitive_commission;
                $total_paper = $request->total_paper;
                $mcqtestpaper = Test::where('competitive_commission_id', $commission_id)
                    ->where('language', $language)
                    ->where('exam_category_id', $category_id)
                    ->where('test_type', $fee_type);
                // full test
                if ($paper_type == 1) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNull('subject_id')->whereNull('chapter_id');
                }
                //subject wise
                if ($paper_type == 2) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('subject_id')->whereNull('chapter_id');
                }
                // chapter wise
                if ($paper_type == 3) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('chapter_id');
                }
                //topic wise
                if ($paper_type == 4) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 0)->whereNotNull('topic_id');
                }

                //current affair
                if ($paper_type == 5) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 2);
                }
                //previous year
                if ($paper_type == 6) {
                    $mcqtestpaper = $mcqtestpaper->where('paper_type', 1);
                }
                $mcqtestpaper = $mcqtestpaper->where('test_paper_type', 'MCQ')->limit($total_paper)->get();
                $passagetestpaper = Test::where('competitive_commission_id', $commission_id)
                    ->where('language', $language)
                    ->where('exam_category_id', $category_id)
                    ->where('test_type', $fee_type);
                // full test
                if ($paper_type == 1) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNull('subject_id')->whereNull('chapter_id');
                }
                //subject wise
                if ($paper_type == 2) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('subject_id')->whereNull('chapter_id');
                }
                // chapter wise
                if ($paper_type == 3) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('chapter_id');
                }
                //topic wise
                if ($paper_type == 4) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 0)->whereNotNull('topic_id');
                }

                //current affair
                if ($paper_type == 5) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 2);
                }
                //previous year
                if ($paper_type == 6) {
                    $passagetestpaper = $passagetestpaper->where('paper_type', 1);
                }
                $passagetestpaper = $passagetestpaper->where('test_paper_type', 'Passage')->limit($total_paper)->get();

                $combinedtestpaper = Test::where('competitive_commission_id', $commission_id)
                    ->where('language', $language)
                    ->where('exam_category_id', $category_id)
                    ->where('test_type', $fee_type);
                // full test
                if ($paper_type == 1) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNull('subject_id')->whereNull('chapter_id');
                }
                //subject wise
                if ($paper_type == 2) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('subject_id')->whereNull('chapter_id');
                }
                // chapter wise
                if ($paper_type == 3) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('chapter_id');
                }
                //topic wise
                if ($paper_type == 4) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 0)->whereNotNull('topic_id');
                }

                //current affair
                if ($paper_type == 5) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 2);
                }
                //previous year
                if ($paper_type == 6) {
                    $combinedtestpaper = $combinedtestpaper->where('paper_type', 1);
                }
                $combinedtestpaper = $combinedtestpaper->where('test_paper_type', 'Combined')->limit($total_paper)->get();

                $subjectivetestpaper = Test::where('competitive_commission_id', $commission_id)
                    ->where('language', $language)
                    ->where('exam_category_id', $category_id)
                    ->where('test_type', $fee_type);
                // full test
                if ($paper_type == 1) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNull('subject_id')->whereNull('chapter_id');
                }
                //subject wise
                if ($paper_type == 2) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('subject_id')->whereNull('chapter_id');
                }
                // chapter wise
                if ($paper_type == 3) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 0)->whereNull('topic_id')->whereNotNull('chapter_id');
                }
                //topic wise
                if ($paper_type == 4) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 0)->whereNotNull('topic_id');
                }

                //current affair
                if ($paper_type == 5) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 2);
                }
                //previous year
                if ($paper_type == 6) {
                    $subjectivetestpaper = $subjectivetestpaper->where('paper_type', 1);
                }
                $subjectivetestpaper = $subjectivetestpaper->where('test_paper_type', 'Subjective')->limit($total_paper)->get();
                // $mcqtestpaper =  $testpapers;
                // $passagetestpaper =  $testpapers;
                // $combinedtestpaper =  $testpapers;
                // $subjectivetestpaper =  $testpapers;
                //$testpaper =  $testpapers->limit($total_paper)->get();




                return response()->json([
                    'success' => true,
                    'mcq_html' => view('admin.ajax.testpaperoptions')->with('testpapers', $mcqtestpaper)->render(),
                    'passage_html' => view('admin.ajax.testpaperoptions')->with('testpapers', $passagetestpaper)->render(),
                    'combined_html' => view('admin.ajax.testpaperoptions')->with('testpapers', $combinedtestpaper)->render(),
                    'subjective_html' => view('admin.ajax.testpaperoptions')->with('testpapers', $subjectivetestpaper)->render(),
                    'questions_count' => $combinedtestpaper->count(),
                ]);
                // if($question_generated_by == 'manual') {

                // } else {
                //     $questions = Question::where('commission_id',$commission_id)
                //         ->where('subject_id',$request->subject)
                //         ->where('language',$language)
                //         ->where('category_id',$category_id)
                //         //->where('sub_category_id',$sub_category_id)
                //         // ->where('question_type', $paper_type)
                //         ->where('topic',$request->topic)
                //             // ->when($paper_type == 1,function($query) use($previous_year){
                //             //     return $query->where('previous_year', $previous_year);
                //             // })
                //             ->limit($question_count)
                //             ->inRandomOrder()
                //             ->get();
                //     return response()->json([
                //         'success' => true,
                //         'html' => view('admin.ajax.questionoptions')->with('questions',$questions)->render(),
                //         'questions_count' => $questions->count(),
                //     ]);

                // }

            } catch (\Exception $ex) {
                return response()->json([
                    'success' => false,
                    'msgText' => $ex->getMessage(),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function generatetestsidepanelquestionslist(Request $request)
    {
        try {
            $mcq_questions = array_values(array_filter(explode(',', $request->mcq_questions)));
            $mca_questions = array_values(array_filter(explode(',', $request->mca_questions)));
            $digit_numeric_questions = array_values(array_filter(explode(',', $request->digit_numeric_questions)));
            $passage_questions = array_values(array_filter(explode(',', $request->passage_questions)));
            $reasoning_questions = array_values(array_filter(explode(',', $request->reasoning_questions)));
            $true_false_questions = array_values(array_filter(explode(',', $request->true_false_questions)));
            $mcq_question_lists = Question::whereIn('id', $mcq_questions)->where('disabled', 'no')->get();
            $mca_question_lists = Question::whereIn('id', $mca_questions)->where('disabled', 'no')->get();
            $digit_numeric_question_lists = Question::whereIn('id', $digit_numeric_questions)->where('disabled', 'no')->get();
            $passage_question_lists = Question::whereIn('id', $passage_questions)->where('disabled', 'no')->get();
            $reasoning_question_lists = Question::whereIn('id', $reasoning_questions)->where('disabled', 'no')->get();
            $true_false_question_lists = Question::whereIn('id', $true_false_questions)->where('disabled', 'no')->get();
            return response()->json([
                'success' => true,
                'html' => view('admin.ajax.test-side-panel-questions-list')->with([
                    'mcq_question_lists' => $mcq_question_lists,
                    'mca_question_lists' => $mca_question_lists,
                    'digit_numeric_question_lists' => $digit_numeric_question_lists,
                    'passage_question_lists' => $passage_question_lists,
                    'reasoning_question_lists' => $reasoning_question_lists,
                    'true_false_question_lists' => $true_false_question_lists,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }
    public function fetchSubject($commission, $category = null, $subcategory = null)
    {
        try {
            ini_set('memory_limit', '-1');
            $subjects = Subject::where('status', 1)->where('exam_com_id', $commission)->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
                ->when($subcategory, function ($query, $subcategory) {
                    return $query->where('sub_category_id', $subcategory);
                })->get();
            // if(isset($commission) && $commission !='')
            // {
            //     $comm = ExaminationCommission::findOrFail($commission);
            //     $subjects =    $subjects->where('exam_com_id',$comm->id);
            // }
            // else if(isset($category) && $category !='')
            // {
            //     $cat = Category::findOrFail($category);
            //     $subjects =    $subjects->where('category_id',$cat->id);
            // }
            // else if(isset($subcategory) && $subcategory !='')
            // {
            //     $subCat = SubCategory::findOrFail($subcategory);
            //     $subjects=  $subjects->where('sub_category_id',$subCat->id);
            // }

            //$subject =  $subjects->get();

            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.subject-by-sub-category')->with([
                    //'subcat' => $subcat,
                    'subjects' => $subjects,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }
    public function fetchchapterbySubject($subject)
    {
        try {
            ini_set('memory_limit', '-1');
            $datas = Chapter::where('status', 1)->where('subject_id', $subject)->get();

            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.options')->with([
                    //'subcat' => $subcat,
                    'datas' => $datas,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }
    public function fetchtopicbychapter($chapter)
    {
        try {
            ini_set('memory_limit', '-1');
            $datas = CourseTopic::where('status', 1)->where('chapter_id', $chapter)->get();

            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.options')->with([
                    //'subcat' => $subcat,
                    'datas' => $datas,
                ])->render(),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

}