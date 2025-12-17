<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\ExaminationCommission;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CourseTopic;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\QuestionDetail;
use App\Imports\QuestionsImport;
use Illuminate\Support\Facades\DB;
use PHPHtmlParser\Dom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionBankController extends Controller
{

    public function index(Request $request)
    {

        try {
            $teacherId = auth()->id(); // get logged-in teacher ID
            if ($request->ajax()) {
                $language = $request->language;
                $question_type = $request->question_type;
                $fee_type = $request->fee_type;
                $question_category = $request->question_category;
                $exam_com_id = $request->exam_com_id;
                $category_id = $request->category_id;
                $sub_category_id = $request->sub_category_id;
                $subject_id = $request->subject_id;
                $chapter_id = $request->chapter_id;
                $topic_id = $request->topic_id;

                $year = $request->question_category == 1 ? $request->previous_year : "";


                $questions = Question::query()
                    ->when($request->language, function ($query, $language) {
                        return $query->where('language', $language);
                    })
                    ->when($request->question_type, function ($query, $question_type) {
                        return $query->where('question_type', $question_type);
                    })
                    ->when($request->fee_type, function ($query, $fee_type) {
                        return $query->where('fee_type', $fee_type);
                    })
                    ->when($request->exam_com_id, function ($query, $exam_com_id) {
                        return $query->where('commission_id', $exam_com_id);
                    })
                    ->when($request->category_id, function ($query, $category_id) {
                        return $query->where('category_id', $category_id);
                    })
                    ->when($request->sub_category_id, function ($query, $sub_category_id) {
                        return $query->where('sub_category_id', $sub_category_id);
                    })
                    ->when($request->subject_id && $request->subject_id != "", function ($query, $subject_id) {
                        return $query->where('subject_id', $subject_id);
                    })
                    ->when($request->chapter_id, function ($query, $chapter_id) {
                        return $query->where('chapter_id', $chapter_id);
                    })
                    ->when($request->topic_id, function ($query, $topic_id) {
                        return $query->where('topic', $topic_id);
                    })
                    ->when($year, function ($query, $year) {
                        return $query->where('previous_year', $year);
                    })
                    ->whereIn('status', ['Done']) // 🔹 Include both Pending and Done
                    ->where('added_by_id', $teacherId) // 🔹 Filter by logged-in teacher
                    ->latest()->paginate(10);

                return view('teachers.question-bank.question-table')->with([
                    'questionBanks' => $questions
                ]);
            } else {
                $data['commissions'] = ExaminationCommission::get();
                $data['questionBanks'] = Question::whereIn('status', ['Done'])
                    ->where('added_by_id', $teacherId) // 🔹 Filter by logged-in teacher
                    ->latest()
                    ->paginate(10);
                return view('teachers.question-bank.index', $data);
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }




    }

    public function rejectQuestionBankIndex()
    {
        $teacherId = auth()->id(); // Logged-in teacher/user ID

        $data['questionBanks'] = Question::where('status', 'Rejected')
            ->where('added_by_id', $teacherId)
            ->paginate(10);

        return view('teachers.question-bank.rejected', $data);
    }

    public function pendingQuestionBankIndex(Request $request)
    {
        $teacherId = auth()->id(); // Logged-in teacher/user ID

        $questions = Question::whereIn('status', ['Pending', 'resubmitted'])
            ->where('added_by_id', $teacherId)
            ->paginate(10);

        return view('teachers.question-bank.pending', [
            'questionBanks' => $questions,
        ]);
    }


    public function questionBankView($id)
    {
        $question = Question::where('id', $id)->with('questionDeatils')->first();
        $data['question'] = $question;
        return view('teachers.question-bank.view', $data);
    }

    public function create()
    {
        $teacher = auth()->user();

        // Allowed languages
        $data['languages'] = $teacher->allow_languages ?? ['1', '2'];

        // Allowed question types
        $allowedQuestionTypes = [];
        if ($teacher->allow_mcq)
            $allowedQuestionTypes[] = 'MCQ';
        if ($teacher->allow_subjective)
            $allowedQuestionTypes[] = 'Subjective';
        if ($teacher->allow_story)
            $allowedQuestionTypes[] = 'Story Based';
        $data['question_types'] = $allowedQuestionTypes;

        // 🔹 Fetch all mappings for this teacher
        $mappings = $teacher->examMappings()->get();

        // Commissions
        $data['commissions'] = ExaminationCommission::whereIn('id', $mappings->pluck('exam_type_id')->unique())->get();

        $data['categories'] = [];
        $data['sub_categories'] = [];
        $data['subjects'] = [];
        $data['chapters'] = [];
        $data['topics'] = [];

        return view('teachers.question-bank.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'category_id' => 'required',
            'subject_id' => 'required',

            'question.*' => 'required',
        ]);

        foreach ($request->question as $qIndex => $questionText) {

            if (empty($questionText)) {
                continue;
            }

            /* ===============================
               MAIN QUESTION
            =============================== */
            $question = new Question();
            $question->language = $request->language;
            $question->question_category = $request->question_category;
            $question->question_type = $request->question_type;
            $question->fee_type = $request->fee_type;
            $question->previous_year = $request->previous_year;
            $question->commission_id = $request->commission_id;
            $question->category_id = $request->category_id;
            $question->sub_category_id = $request->sub_category_id;
            $question->subject_id = $request->subject_id;
            $question->chapter_id = $request->chapter_id;
            $question->topic = $request->topic;
            $question->question = $questionText;

            $question->has_instruction = $request->has_instruction ? true : false;
            $question->instruction = $request->has_instruction ? $request->instruction : null;
            $question->has_option_e = $request->has_option_e ? true : false;
            $question->show_on_pyq = $request->show_on_pyq ?? 'no';

            /* ===============================
               MCQ / SUBJECTIVE ANSWERS
            =============================== */
            $question->answer = $request->answer[$qIndex] ?? null;
            $question->option_a = $request->option_a[$qIndex] ?? null;
            $question->option_b = $request->option_b[$qIndex] ?? null;
            $question->option_c = $request->option_c[$qIndex] ?? null;
            $question->option_d = $request->option_d[$qIndex] ?? null;
            $question->option_e = $request->has_option_e ? ($request->option_e[$qIndex] ?? null) : null;

            $solution = $request->solution[$qIndex] ?? null;
            $question->has_solution = !empty($solution) ? 'yes' : 'no';
            $question->solution = $solution;

            $question->answer_format = $request->answer_format[$qIndex] ?? null;

            // Assign the teacher who added the question
            $question->added_by_id = auth()->id();
            $question->added_by_type = 'teacher';
            $question->status = 'pending';

            $question->save();

            /* ===============================
               STORY BASED → SUB QUESTIONS
            =============================== */
            if ($request->question_type === 'Story Based') {

                foreach ($request->sub_question as $sIndex => $subQuestionText) {

                    if (empty(strip_tags($subQuestionText))) {
                        continue;
                    }

                    $detail = new QuestionDetail();
                    $detail->question_id = $question->id;
                    $detail->question = $subQuestionText;

                    // ✅ SET TYPE PROPERLY
                    $detail->type = $request->sub_question_type[$sIndex] ?? 'mcq';

                    /* ---------- MCQ SUB QUESTION ---------- */
                    if ($detail->type === 'mcq') {

                        $detail->option_a = $request->option_a[$sIndex] ?? null;
                        $detail->option_b = $request->option_b[$sIndex] ?? null;
                        $detail->option_c = $request->option_c[$sIndex] ?? null;
                        $detail->option_d = $request->option_d[$sIndex] ?? null;

                        $detail->answer = $request->answer[$sIndex] ?? null;
                    }

                    /* ---------- REASONING / SUBJECTIVE ---------- */
                    if ($detail->type === 'reasoning') {
                        $detail->answer_format = $request->answer_format[$sIndex] ?? null;
                    }

                    /* ---------- SOLUTION ---------- */
                    $detail->solution = $request->solution[$sIndex] ?? null;

                    $detail->save();
                }
            }


        }

        return redirect()->route('teacher.question.bank.index')->with('success', 'Questions created successfully.');
    }


    public function questionBankBulkUpload()
    {
        $teacher = auth()->user();

        // Allowed languages
        $data['languages'] = $teacher->allow_languages ?? ['1', '2'];

        // Allowed question types
        $allowedQuestionTypes = [];
        if ($teacher->allow_mcq)
            $allowedQuestionTypes[] = 'MCQ';
        if ($teacher->allow_subjective)
            $allowedQuestionTypes[] = 'Subjective';
        if ($teacher->allow_story)
            $allowedQuestionTypes[] = 'Story Based';
        $data['question_types'] = $allowedQuestionTypes;

        // 🔹 Fetch all mappings for this teacher
        $mappings = $teacher->examMappings()->get();

        // Commissions
        $data['commissions'] = ExaminationCommission::whereIn('id', $mappings->pluck('exam_type_id')->unique())->get();

        $data['categories'] = [];
        $data['sub_categories'] = [];
        $data['subjects'] = [];
        $data['chapters'] = [];
        $data['topics'] = [];

        return view('teachers.question-bank.bulk-upload', $data);
    }

    public function questionBankEdit($id)
    {
        $question = Question::where('id', $id)->with('questionDeatils')->first();
        $teacher = auth()->user();

        // Allowed languages
        $data['languages'] = $teacher->allow_languages ?? ['1', '2'];

        // Allowed question types
        $allowedQuestionTypes = [];
        if ($teacher->allow_mcq)
            $allowedQuestionTypes[] = 'MCQ';
        if ($teacher->allow_subjective)
            $allowedQuestionTypes[] = 'Subjective';
        if ($teacher->allow_story)
            $allowedQuestionTypes[] = 'Story Based';
        $data['question_types'] = $allowedQuestionTypes;

        // 🔹 Fetch all mappings for this teacher
        $mappings = $teacher->examMappings()->get();

        // Commissions
        $data['commissions'] = ExaminationCommission::whereIn('id', $mappings->pluck('exam_type_id')->unique())->get();

        // 🔹 Only mapped categories
        if ($question->commission_id) {
            $mappedCategories = $mappings->where('exam_type_id', $question->commission_id)
                ->pluck('category_id')->unique()->toArray();
            $data['categories'] = Category::whereIn('id', $mappedCategories)->get();
        } else {
            $data['categories'] = [];
        }

        // 🔹 Only mapped subcategories
        if ($question->category_id) {
            $mappedSubCategories = $mappings->where('category_id', $question->category_id)
                ->pluck('sub_category_id')->unique()->toArray();
            $data['subcategories'] = SubCategory::whereIn('id', $mappedSubCategories)->get();
        } else {
            $data['subcategories'] = [];
        }

        // 🔹 Only mapped subjects
        if ($question->sub_category_id) {
            $mappedSubjects = $mappings->where('sub_category_id', $question->sub_category_id)
                ->pluck('subject_id')->unique()->toArray();
            $data['subjects'] = Subject::whereIn('id', $mappedSubjects)->get();
        } else {
            $data['subjects'] = [];
        }

        // Chapters and topics (can remain as normal)
        $data['chapters'] = $question->subject_id ? Chapter::where('subject_id', $question->subject_id)->get() : [];
        $data['topics'] = $question->chapter_id ? CourseTopic::where('chapter_id', $question->chapter_id)->get() : [];

        $data['question'] = $question;
        $data['added_by_id'] = $question->added_by_id;
        $data['status'] = $question->status;


        return view('teachers.question-bank.edit', $data);
    }


    public function questionBankUpdate(Request $request, $id)
    {
        $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'category_id' => 'required',
            'subject_id' => 'required',
            'question.*' => 'required',
        ]);

        /* ======================================
           UPDATE MAIN QUESTION (ONLY ONE RECORD)
        ====================================== */
        $question = Question::findOrFail($id);

        $question->language = $request->language;
        $question->question_category = $request->question_category;
        $question->question_type = $request->question_type;
        $question->fee_type = $request->fee_type;
        $question->previous_year = $request->previous_year;
        $question->commission_id = $request->commission_id;
        $question->category_id = $request->category_id;
        $question->sub_category_id = $request->sub_category_id;
        $question->subject_id = $request->subject_id;
        $question->chapter_id = $request->chapter_id;
        $question->topic = $request->topic;

        // MAIN QUESTION TEXT
        $question->question = $request->question[0];

        $question->has_instruction = $request->has_instruction ? true : false;
        $question->instruction = $request->has_instruction ? $request->instruction : null;
        $question->has_option_e = $request->has_option_e ? true : false;
        $question->show_on_pyq = $request->show_on_pyq ?? 'no';

        /* ======================================
           MCQ / SUBJECTIVE MAIN ANSWER
        ====================================== */
        if ($request->question_type === 'MCQ') {
            $question->answer = $request->answer[0] ?? null;
            $question->option_a = $request->option_a[0] ?? null;
            $question->option_b = $request->option_b[0] ?? null;
            $question->option_c = $request->option_c[0] ?? null;
            $question->option_d = $request->option_d[0] ?? null;
            $question->option_e = $request->has_option_e ? ($request->option_e[0] ?? null) : null;
        }

        if ($request->question_type === 'Subjective') {
            $question->answer_format = $request->answer_format[0] ?? null;
        }

        $solution = $request->solution[0] ?? null;
        $question->has_solution = !empty($solution) ? 'yes' : 'no';
        $question->solution = $solution;

        $question->save();

        /* ======================================
           STORY BASED → SUB QUESTIONS
        ====================================== */
        if ($request->question_type === 'Story Based') {

            $incomingIds = [];

            foreach ($request->sub_question as $sIndex => $subQuestionText) {

                // Skip empty sub questions
                if (empty(strip_tags($subQuestionText))) {
                    continue;
                }

                $subId = $request->sub_question_id[$sIndex] ?? null;

                // 🔹 EXISTING sub-question → update
                if (!empty($subId)) {
                    $detail = QuestionDetail::where('id', $subId)
                        ->where('question_id', $question->id)
                        ->first();
                }
                // 🔹 NEW sub-question → create
                else {
                    $detail = new QuestionDetail();
                    $detail->question_id = $question->id;
                }

                if (!$detail) {
                    continue;
                }

                $detail->question = $subQuestionText;
                $detail->type = $request->sub_question_type[$sIndex] ?? 'mcq';

                /* ===============================
                   MCQ SUB QUESTION
                =============================== */
                if ($detail->type === 'mcq') {
                    $detail->option_a = $request->option_a[$sIndex] ?? null;
                    $detail->option_b = $request->option_b[$sIndex] ?? null;
                    $detail->option_c = $request->option_c[$sIndex] ?? null;
                    $detail->option_d = $request->option_d[$sIndex] ?? null;
                    $detail->answer = $request->answer[$sIndex] ?? null;

                    // clear reasoning-only fields
                    $detail->answer_format = null;
                }

                /* ===============================
                   REASONING / SUBJECTIVE
                =============================== */
                if ($detail->type === 'reasoning') {
                    $detail->answer_format = $request->answer_format[$sIndex] ?? null;

                    // clear MCQ-only fields
                    $detail->option_a = null;
                    $detail->option_b = null;
                    $detail->option_c = null;
                    $detail->option_d = null;
                    $detail->answer = null;
                }

                /* ===============================
                   SOLUTION
                =============================== */
                $detail->solution = $request->solution[$sIndex] ?? null;

                $detail->save();

                // Track IDs that are still valid
                $incomingIds[] = $detail->id;
            }

            /* ===============================
               DELETE REMOVED SUB QUESTIONS
            =============================== */
            QuestionDetail::where('question_id', $question->id)
                ->whereNotIn('id', $incomingIds)
                ->delete();
        }


        /* ======================================
           RECHECK STATUS (ONLY IF REJECTED)
        ====================================== */
        if ($question->status === 'Rejected') {

            $status = 'Resubmitted';
            $note = null;

            $cleanQuestion = trim(preg_replace('/\s+/', ' ', strip_tags($question->question)));

            $duplicate = Question::whereRaw(
                'LOWER(REPLACE(REPLACE(REPLACE(question, "<p>", ""), "</p>", ""), "&nbsp;", "")) LIKE ?',
                ['%' . strtolower($cleanQuestion) . '%']
            )
                ->where('commission_id', $request->commission_id)
                ->where('category_id', $request->category_id)
                ->where('sub_category_id', $request->sub_category_id)
                ->where('subject_id', $request->subject_id)
                ->where('id', '!=', $question->id)
                ->exists();

            if ($duplicate) {
                $status = 'Rejected';
                $note = 'Already Exists Question.';
            }

            // MCQ format check
            if ($status !== 'Rejected' && $request->question_type === 'MCQ') {
                if (
                    empty($question->question) ||
                    empty($question->option_a) ||
                    empty($question->option_b) ||
                    empty($question->option_c) ||
                    empty($question->option_d) ||
                    empty($question->answer)
                ) {
                    $status = 'Rejected';
                    $note = 'Question Format Issue';
                }
            }

            // Subjective format check
            if ($status !== 'Rejected' && $request->question_type === 'Subjective') {
                if (empty($question->answer_format)) {
                    $status = 'Rejected';
                    $note = 'Please enter Answer format';
                }
            }

            // Story Based format check
            if ($status !== 'Rejected' && $request->question_type === 'Story Based') {
                if (empty($request->sub_question)) {
                    $status = 'Rejected';
                    $note = 'Question Format Issue';
                }
            }

            $question->status = $status;
            $question->note = $note;
            $question->save();
        }

        return redirect()
            ->route('teacher.question.bank.index')
            ->with('success', 'Question updated and resubmitted successfully.');
    }


    public function ImportQuestions(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'previous_year' => 'nullable|integer',
            'category_id' => 'required',
            'subject_id' => 'required',
            'topic' => 'nullable',

            'file' => 'required|mimes:docx,xlsx',
        ]);

        // Create a new instance of QuestionBank model
        // $questionBank = new QuestionBank();

        // // Assign values to the model properties
        // $questionBank->language = $request->language;
        // $questionBank->question_category = $request->question_category;
        // $questionBank->commission_id = $request->commission_id;
        // $questionBank->previous_year = $request->previous_year;
        // $questionBank->category_id = $request->category_id;
        // $questionBank->sub_category_id = $request->sub_category_id;
        // $questionBank->chapter_id = $request->chapter_id;
        // $questionBank->subject_id = $request->subject_id;
        // $questionBank->topic = $request->topic;



        try {
            $questionData = array();
            if ($request->file->getClientOriginalExtension() == 'docx') {
                $filename = $request->file;
                $time = microtime();
                $outputPath = storage_path($time . '.html');

                $filename = $request->file->getRealPath();
                // unzip .docx temporarily
                $zip = new \ZipArchive;
                if ($zip->open($filename) === TRUE) {
                    $xml = $zip->getFromName('word/document.xml');
                    // remove Office Math tags
                    $xml = preg_replace('/<m:oMath[^>]*>.*?<\/m:oMath>/is', '', $xml);
                    $xml = preg_replace('/<m:oMathPara[^>]*>.*?<\/m:oMathPara>/is', '', $xml);
                    $zip->addFromString('word/document.xml', $xml);
                    $zip->close();
                }

                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filename);
                $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
                $htmlWriter->save($outputPath);
                $this->replaceThWithTd($outputPath);
                $dom = new Dom;
                $dom->loadFromFile($outputPath);


                $tables = $dom->find('table');
                $successCount = 0;
                $pendingCount = 0;
                $rejectedCount = 0;
                $successdata = [];
                $pendingdata = [];
                $rejecteddata = [];
                $option_a = NULL;
                $option_b = NULL;
                $option_c = NULL;
                $option_d = NULL;
                $option_e = NULL;
                $image = NULL;
                $solution = NULL;
                $answer = NULL;
                $instruction = NULL;
                $has_option_e = false;
                $has_solution = "no";
                $has_instruction = false;
                if ($request->question_type == 'MCQ') {
                    for ($i = 0; $i < count($tables); $i++) {
                        try {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_a = NULL;
                            } else {
                                $option_a = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_b = NULL;
                            } else {
                                $option_b = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_c = NULL;
                            } else {
                                $option_c = $tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_d = NULL;
                            } else {
                                $option_d = $tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml;
                            }

                            $rejectQuestion = false;
                            $rejectNote = '';

                            // Option E (optional)
                            $tr5 = $tables[$i]->find('tr', 5);
                            $td5 = $tr5 ? $tr5->find('td', 1) : null;
                            $p5 = $td5 ? $td5->find('p') : null;

                            $rawHtml = $p5 ? trim($p5->innerHtml) : '';
                            $textOnly = trim(strip_tags($rawHtml)); // used ONLY for empty check

                            // Check if Option E is actually empty
                            if ($textOnly === '' || $textOnly === '&nbsp;' || $rawHtml === '&nbsp;') {
                                $option_e = null;
                                $has_option_e = false;
                            } else {
                                // Keep original HTML as required
                                $option_e = $rawHtml;
                                $has_option_e = true;
                            }

                            // Answer (mandatory)
                            $tr6 = $tables[$i]->find('tr', 6);
                            $td6 = $tr6 ? $tr6->find('td', 1) : null;
                            $p6 = $td6 ? $td6->find('p') : null;
                            if ($p6 === null) {
                                $answer = null;
                                $rejectQuestion = true;
                                $rejectNote = 'Question Format Issue';
                            } else {
                                $span = $p6->find('span');
                                $answer = $span ? $span->innerHtml : null;
                                if (!$answer) {
                                    $rejectQuestion = true;
                                    $rejectNote = 'Question Format Issue';
                                }
                            }

                            // Instruction (optional)
                            $tr7 = $tables[$i]->find('tr', 7);
                            $td7 = $tr7 ? $tr7->find('td', 1) : null;
                            $p7 = $td7 ? $td7->find('p') : null;
                            if ($p7 === null || $p7->innerHtml === '&nbsp;') {
                                $instruction = null;
                                $has_instruction = false;
                            } else {
                                $instruction = $td7->innerHtml;
                                $has_instruction = true;
                            }

                            $solution = null;
                            $has_solution = 'no';

                            $tryRows = [8, 9];

                            foreach ($tryRows as $rowIdx) {

                                $tr = $tables[$i]->find('tr', $rowIdx);
                                $td = $tr ? $tr->find('td', 1) : null;
                                $p = $td ? $td->find('p') : null;

                                // Raw HTML
                                $rawHtml = $p ? trim($p->innerHtml) : '';

                                // Text-only content (after removing tags)
                                $textOnly = trim(strip_tags($rawHtml));

                                // Check if empty
                                if ($textOnly === '' || $rawHtml === '&nbsp;' || $textOnly === '&nbsp;') {
                                    continue; // move to next row
                                }

                                // Valid solution found → KEEP full HTML
                                $solution = $rawHtml;
                                $has_solution = 'yes';
                                break;
                            }


                            // Finally, set status once
                            if ($rejectQuestion) {
                                $questionData['status'] = 'Rejected';
                                $questionData['note'] = $rejectNote;
                            } else {
                                $questionData['status'] = 'Done'; // or success after insert
                            }
                            // $que =   QuestionBank::where('question',$question)
                            // // ->where('question_category',$request->question_category)
                            // // ->where('commission_id',$request->commission_id)
                            // // ->where('category_id',$request->category_id)
                            //  ->where('subject_id',$request->subject_id)
                            // ->where('topic',$request->topic);

                            // $que = $que->first();

                            // Create a new instance of QuestionBank model
                            // $questionBank = new QuestionBank();

                            // // Assign values to the model properties
                            // $questionBank->language = $request->language;
                            // $questionBank->question_category = $request->question_category;
                            // $questionBank->commission_id = $request->commission_id;
                            // $questionBank->previous_year = $request->previous_year;
                            // $questionBank->category_id = $request->category_id;
                            // $questionBank->subject_id = $request->subject_id;
                            // $questionBank->topic = $request->topic;
                            // $questionBank->has_instruction = $has_instruction;
                            // $questionBank->instruction = $instruction;
                            // $questionBank->has_option_e = $has_option_e;
                            // $questionBank->question = $question;
                            // // Save the question bank to the database
                            // $questionBank->save();



                            $questionData['language'] = $request->language;
                            $questionData['question_category'] = $request->question_category;
                            $questionData['question_type'] = $request->question_type;
                            $questionData['fee_type'] = $request->fee_type;
                            $questionData['commission_id'] = $request->commission_id;
                            $questionData['previous_year'] = $request->previous_year;
                            $questionData['category_id'] = $request->category_id;
                            $questionData['sub_category_id'] = $request->sub_category_id;
                            $questionData['chapter_id'] = $request->chapter_id;
                            $questionData['subject_id'] = $request->subject_id;
                            $questionData['topic'] = $request->topic;
                            //$questionData['question_bank_id'] = $questionBank->id ?? 0;
                            $questionData['question'] = $question;
                            $questionData['option_a'] = $option_a;
                            $questionData['option_b'] = $option_b;
                            $questionData['option_c'] = $option_c;
                            $questionData['option_d'] = $option_d;
                            $questionData['option_e'] = $option_e;
                            $questionData['image'] = $image;
                            $questionData['answer'] = strtoupper(Str::of($answer)->trim());
                            $questionData['has_solution'] = $has_solution;
                            $questionData['solution'] = $solution;
                            // Add this in your $questionData array before saving
                            $questionData['added_by_id'] = auth()->id(); // Logged in teacher/user
                            $questionData['added_by_type'] = 'teacher';
                            $questionData['status'] = 'Pending';

                            $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                                ->where('sub_category_id', $request->sub_category_id)
                                ->where('chapter_id', $request->chapter_id);
                            if ($request->previous_year) {
                                $que = $que->where('previous_year', $request->previous_year);
                            }
                            $que = $que->first();

                            if ($que) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Already Exists Question.";
                                $qsave = Question::create($questionData);

                            } else {

                                $insert = Question::create($questionData);
                                if ($insert) {
                                    $successCount = $successCount + 1;
                                    $successdata[] = $questionData;
                                }

                            }
                        } catch (\Exception $ex) {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml ?? NULL;
                            $rejectedCount = $rejectedCount + 1;
                            $questionData['status'] = "Rejected";
                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue';
                            Question::create($questionData);

                        }

                    }
                } elseif ($request->question_type == 'Subjective') {

                    for ($i = 1; $i < count($tables); $i++) {
                        try {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $image = NULL;
                            } else {
                                $imageElement = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->find('img');

                                if (count($imageElement) > 0) {
                                    $image_64 = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->find('img')->src;
                                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                                    $image = 'question/' . Str::random(40) . '.' . $extension;
                                    Storage::put($image, file_get_contents($image_64));
                                } else {
                                    $image = NULL;
                                }


                            }
                            $answer_format = NULL;
                            if ($tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $answer_format = NULL;
                            } else {
                                $answer_format = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                            }

                            // Get the <p> inside row 3
                            $tr = $tables[$i]->find('tr', 3);
                            $td = $tr ? $tr->find('td', 1) : null;
                            $p = $td ? $td->find('p') : null;

                            // Safely extract HTML
                            $rawHtml = $p ? trim($p->innerHtml) : '';

                            // Strip HTML to detect real text
                            $textOnly = trim(strip_tags($rawHtml));

                            // Check if solution is actually empty
                            if ($rawHtml === '' || $rawHtml === '&nbsp;' || $textOnly === '') {
                                $solution = null;
                                $has_solution = 'no';
                            } else {
                                // Keep full HTML
                                $solution = $rawHtml;
                                $has_solution = 'yes';
                            }

                            if ($tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $instruction = NULL;
                                $has_instruction = false;
                            } else {
                                $instruction = $tables[$i]->find('tr', 4)->find('td', 1)->innerHtml;
                                $has_instruction = true;
                            }
                            $questionData['language'] = $request->language;
                            $questionData['question_category'] = $request->question_category;
                            $questionData['question_type'] = $request->question_type;
                            $questionData['fee_type'] = $request->fee_type;
                            $questionData['commission_id'] = $request->commission_id;
                            $questionData['previous_year'] = $request->previous_year;
                            $questionData['category_id'] = $request->category_id;
                            $questionData['sub_category_id'] = $request->sub_category_id;
                            $questionData['chapter_id'] = $request->chapter_id;
                            $questionData['subject_id'] = $request->subject_id;
                            $questionData['topic'] = $request->topic;
                            $questionData['question'] = $question;
                            $questionData['solution'] = $solution;
                            $questionData['image'] = $image;
                            $questionData['answer_format'] = strip_tags($answer_format);
                            $questionData['has_solution'] = $has_solution;
                            $questionData['instruction'] = $instruction;
                            $questionData['has_instruction'] = $has_instruction;

                            $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                                ->where('sub_category_id', $request->sub_category_id)
                                ->where('chapter_id', $request->chapter_id);
                            if ($request->previous_year) {
                                $que = $que->where('previous_year', $request->previous_year);
                            }
                            $que = $que->first();
                            if (!$answer_format) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Please enter Answer format";
                                $qsave = Question::create($questionData);

                            } elseif ($que) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Already Exists Question.";
                                $qsave = Question::create($questionData);
                            } else {
                                $successCount = $successCount + 1;
                                $insert = Question::create($questionData);
                                $successdata[] = $questionData;
                            }

                        } catch (\Exception $ex) {

                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            $rejectedCount = $rejectedCount + 1;

                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue';

                            $questionData['status'] = "Rejected";
                            Question::create($questionData);
                        }
                    }
                } elseif ($request->question_type == 'Story Based') {
                    try {

                        $question = $tables[1]->find('tr', 0)->find('td', 1)->innerHtml;
                        if ($tables[1]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                            $image = NULL;
                        } else {
                            $imageElement = $tables[1]->find('tr', 1)->find('td', 1)->find('p')->find('img');

                            if (count($imageElement) > 0) {
                                $image_64 = $tables[1]->find('tr', 1)->find('td', 1)->find('p')->find('img')->src;
                                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                                $image = 'question/' . Str::random(40) . '.' . $extension;
                                Storage::put($image, file_get_contents($image_64));
                            } else {
                                $image = NULL;
                            }


                        }
                        // if ($tables[1]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                        $solution = NULL;
                        $has_solution = 'no';
                        // } else {
                        //     $solution = $tables[1]->find('tr', 2)->find('td', 1)->innerHtml;
                        //     $has_solution = 'yes';
                        // }
                        if ($tables[1]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                            $instruction = NULL;
                            $has_instruction = false;
                        } else {
                            $instruction = $tables[1]->find('tr', 2)->find('td', 1)->innerHtml;
                            $has_instruction = true;
                        }
                        $answer_format = NULL;
                        if ($request->passage_question_type == 'reasoning_subjective') {
                            if ($tables[1]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $answer_format = NULL;
                            } else {
                                $answer_format = $tables[1]->find('tr', 3)->find('td', 1)->find('p');
                            }
                        }


                        $questionData['language'] = $request->language;
                        $questionData['question_category'] = $request->question_category;
                        $questionData['question_type'] = $request->question_type;
                        $questionData['passage_question_type'] = $request->passage_question_type;
                        $questionData['fee_type'] = $request->fee_type;
                        $questionData['commission_id'] = $request->commission_id;
                        $questionData['previous_year'] = $request->previous_year;
                        $questionData['category_id'] = $request->category_id;
                        $questionData['sub_category_id'] = $request->sub_category_id;
                        $questionData['chapter_id'] = $request->chapter_id;
                        $questionData['subject_id'] = $request->subject_id;
                        $questionData['topic'] = $request->topic;
                        $questionData['question'] = $question;
                        $questionData['solution'] = $solution;
                        $questionData['answer_format'] = $answer_format;
                        $questionData['has_solution'] = $has_solution;
                        $questionData['instruction'] = $instruction;
                        $questionData['has_instruction'] = $has_instruction;

                        $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                            ->where('sub_category_id', $request->sub_category_id)
                            ->where('chapter_id', $request->chapter_id);
                        if ($request->previous_year) {
                            $que = $que->where('previous_year', $request->previous_year);
                        }
                        $que = $que->first();
                        if ($que) {
                            $rejectedCount = $rejectedCount + 1;
                            $questionData['status'] = "Rejected";
                            $questionData['note'] = "Already Exists Question.";
                            $ques = Question::create($questionData);

                        } else {
                            $successCount = $successCount + 1;
                            $successdata[] = $questionData;
                            $ques = Question::create($questionData);
                        }

                        if ($ques) {
                            //if($request->passage_question_type == 'reasoning_subjective') {
                            for ($i = 2; $i < count($tables); $i++) {

                                $option_c = $tables[$i]->find('tr', 3);
                                if (!isset($option_c) && $option_c == "") {
                                    $passage_question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                                    $passage_answer_format = NULL;
                                    if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                        $passage_answer_format = NULL;
                                    } else {
                                        $passage_answer_format = $tables[$i]->find('tr', 1)->find('td', 1)->find('p');
                                    }
                                    // Try to read per-subquestion solution at row 2
                                    $detail_solution = NULL;
                                    $solTr = $tables[$i]->find('tr', 2);
                                    $solTd = $solTr ? $solTr->find('td', 1) : null;
                                    if ($solTd && trim($solTd->innerHtml) !== '' && $solTd->innerHtml !== '&nbsp;') {
                                        $detail_solution = $solTd->innerHtml;
                                    }
                                    $question_detail = ([
                                        'question_id' => $ques->id,
                                        'question' => $passage_question,
                                        'answer_format' => $passage_answer_format,
                                    ]);
                                    if ($detail_solution !== NULL) {
                                        $question_detail['solution'] = $detail_solution;
                                    }
                                    QuestionDetail::create($question_detail);
                                } else {
                                    $passage_question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                                    $option_a = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml;
                                    $option_b = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                                    $option_c = $tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml;
                                    $option_d = $tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml;


                                    $tr5 = $tables[$i]->find('tr', 5);
                                    $td5 = $tr5 ? $tr5->find('td', 1) : null;
                                    $p5 = $td5 ? $td5->find('p') : null;

                                    $rawHtml = $p5 ? trim($p5->innerHtml) : '';
                                    $textOnly = trim(strip_tags($rawHtml)); // used only to detect empty value

                                    // If Option E is actually empty
                                    if ($textOnly === '' || $rawHtml === '&nbsp;' || $textOnly === '&nbsp;') {
                                        $option_e = null;
                                        $has_option_e = false;
                                    } else {
                                        // KEEP original HTML (as required)
                                        $option_e = $rawHtml;
                                        $has_option_e = true;
                                    }


                                    $passage_answer = $tables[$i]->find('tr', 6)->find('td', 1)->find('p')->innerHtml;
                                    // Try to read per-subquestion solution at row 7 or 8
                                    $detail_solution = NULL;
                                    $solTr = $tables[$i]->find('tr', 7);
                                    $solTd = $solTr ? $solTr->find('td', 1) : null;
                                    if ($solTd && trim($solTd->innerHtml) !== '' && $solTd->innerHtml !== '&nbsp;') {
                                        $detail_solution = $solTd->innerHtml;
                                    } else {
                                        $solTr2 = $tables[$i]->find('tr', 8);
                                        $solTd2 = $solTr2 ? $solTr2->find('td', 1) : null;
                                        if ($solTd2 && trim($solTd2->innerHtml) !== '' && $solTd2->innerHtml !== '&nbsp;') {
                                            $detail_solution = $solTd2->innerHtml;
                                        }
                                    }
                                    $question_detail = ([
                                        'question_id' => $ques->id,
                                        'question' => $passage_question,
                                        'answer' => strtoupper(Str::of(strip_tags($passage_answer))->trim()),
                                        'option_a' => $option_a,
                                        'option_b' => $option_b,
                                        'option_c' => $option_c,
                                        'option_d' => $option_d,
                                        'option_e' => $option_e,
                                        'has_option_e' => $has_option_e,
                                    ]);
                                    if ($detail_solution !== NULL) {
                                        $question_detail['solution'] = $detail_solution;
                                    }
                                    QuestionDetail::create($question_detail);
                                }

                            }




                            // } elseif($request->passage_question_type == 'multiple_choice') {

                            // }
                        }

                    } catch (\Exception $ex) {
                        $question = $tables[1]->find('tr', 0)->find('td', 1)->innerHtml;
                        $rejectedCount = $rejectedCount + 1;
                        $questionData = [];
                        $questionData['question'] = $question;
                        $questionData['note'] = 'Question Format Issue';
                        $questionData['question_type'] = $request->question_type;
                        $questionData['status'] = "Rejected";
                        $ques = Question::create($questionData);
                    }
                }

                DB::commit();
                return redirect()->route('teacher.question.bank.index')->with('success', 'Questions created successfully.');
                // session(['success_data' => $successdata]);
                // session(['pending_data' => $pendingdata]);
                // session(['rejected_data' => $rejecteddata]);
                // return response()->json([
                //     'success' => true,
                //     'successCount' => $successCount,
                //     'rejectedCount' => $rejectedCount,
                //     'pendingCount' => count($tables) - $successCount - $rejectedCount - 1,
                //     'msgText' => 'Upload Successfull',
                // ]);
                // return redirect(route('admin.upload-question','type='.$exam_type))->with('success','Upload Successfull');
            } else {
                $import = new QuestionsImport($request->all());

                $import->import($request->file);
                // dd($import);
                $file = $request->file('file');

                $successCount = $import->getSuccessCount();
                $rejectedCount = $import->getRejectedCount();
                $pendingCount = $import->getRowCount() - $successCount - $rejectedCount;
                DB::commit();
                // return response()->json([
                //     'success' => true,
                //     'successCount' => $successCount,
                //     'rejectedCount' => $rejectedCount,
                //     'pendingCount' => $pendingCount,
                //     'msgText' => 'Question Updated Successfully',
                // ]);
                return redirect()->route('teacher.question.bank.index')->with('success', 'Questions created successfully.');
                // return redirect(route('admin.upload-question','type='.$exam_type))->with('success','Upload Successfull');
            }
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('teacher.question.bank.bulk-upload')->with('success', 'Something went wrong.');
        }


    }

    public function replaceThWithTd($htmlFilePath)
    {
        // Load the HTML
        $html = file_get_contents($htmlFilePath);

        // Create DOMDocument and load HTML
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress warnings
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Get all <th> elements
        $thElements = $dom->getElementsByTagName('th');

        // We need to loop backwards because we'll be replacing nodes in-place
        for ($i = $thElements->length - 1; $i >= 0; $i--) {
            $th = $thElements->item($i);

            // Create new <td> element
            $td = $dom->createElement('td');

            // Copy attributes
            if ($th->hasAttributes()) {
                foreach ($th->attributes as $attr) {
                    $td->setAttribute($attr->nodeName, $attr->nodeValue);
                }
            }

            // Copy child nodes (text, formatting, etc.)
            foreach (iterator_to_array($th->childNodes) as $child) {
                $td->appendChild($child->cloneNode(true));
            }

            // Replace <th> with <td>
            $th->parentNode->replaceChild($td, $th);
        }

        // Save the updated HTML
        file_put_contents($htmlFilePath, $dom->saveHTML());
    }

    public function questionBankDelete($id)
    {
        //  $question = QuestionBank::findOrFail($id);
        //  if($question)
        //  {
        $que = Question::where('id', $id)->first();
        $que->delete();
        //  }
        // $question->delete();
        return redirect()->back()->with('success', 'Question Bank deleted successfully.');
    }

    public function fetchCategoriesByCommission($commissionId)
    {
        $teacher = auth()->user();

        $mappings = $teacher->examMappings()->where('exam_type_id', $commissionId)->get();
        $categories = Category::whereIn('id', $mappings->pluck('category_id')->unique())->get();

        $html = '<option value="">--Select--</option>';
        foreach ($categories as $cat) {
            $html .= "<option value='{$cat->id}'>{$cat->name}</option>";
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function fetchSubcategoriesByCategory($categoryId)
    {
        $teacher = auth()->user();

        $mappings = $teacher->examMappings()->where('category_id', $categoryId)->get();
        $subcategories = SubCategory::whereIn('id', $mappings->pluck('sub_category_id')->unique())->get();

        $html = '<option value="">--Select--</option>';
        foreach ($subcategories as $sub) {
            $html .= "<option value='{$sub->id}'>{$sub->name}</option>";
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function fetchSubjectsBySubcategory($categoryId)
    {
        $teacher = auth()->user();

        $mappings = $teacher->examMappings()->where('sub_category_id', $categoryId)->get();
        $subjects = Subject::whereIn('id', $mappings->pluck('subject_id')->unique())->get();

        $html = '<option value="">--Select--</option>';
        foreach ($subjects as $subj) {
            $html .= "<option value='{$subj->id}'>{$subj->name}</option>";
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

}
