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

    /**
     * Safely get inner HTML from a table cell (tr -> td -> p), or fall back to td innerHtml.
     * Returns null if the row/cell doesn't exist instead of throwing.
     */
    private function getCellHtml($table, int $rowIndex, int $colIndex = 1)
    {
        $tr = $table->find('tr', $rowIndex);
        if (!$tr) {
            return null;
        }
        $td = $tr->find('td', $colIndex);
        if (!$td) {
            return null;
        }
        $p = $td->find('p');
        if ($p) {
            return trim($p->innerHtml);
        }
        return trim($td->innerHtml);
    }

    /**
     * Determine whether a cell's HTML is "empty" (nbsp, blank, or only whitespace after stripping tags).
     */
    private function isEmptyCell(?string $html): bool
    {
        if ($html === null) {
            return true;
        }
        if ($html === '&nbsp;') {
            return true;
        }
        $decoded = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(str_replace("\xc2\xa0", '', strip_tags($decoded)));
        return $text === '';
    }

    public function ImportQuestions(Request $request)
    {
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

        DB::beginTransaction();

        try {
            $questionData = array();
            if ($request->file->getClientOriginalExtension() == 'docx') {
                $filename = $request->file;
                $time = microtime(true);
                $outputPath = storage_path('import_' . $time . '.html');

                $filename = $request->file->getRealPath();

                // unzip .docx temporarily
                $zip = new \ZipArchive;
                if ($zip->open($filename) === TRUE) {
                    $xml = $zip->getFromName('word/document.xml');

                    // Convert Office Math (equations) to plain text instead of deleting them.
                    // Previously these were stripped entirely with preg_replace(..., ''), which
                    // wiped out simple numeric/percentage expressions (e.g. "2+2=4", "25%") that
                    // Word had encoded as <m:oMath> equation objects rather than plain text runs.
                    // That left required cells (like the Answer cell) empty, causing valid
                    // questions to be rejected with "Question Format Issue".
                    $xml = preg_replace_callback('/<m:oMathPara[^>]*>(.*?)<\/m:oMathPara>/is', function ($m) {
                        preg_match_all('/<m:t[^>]*>(.*?)<\/m:t>/is', $m[1], $t);
                        return implode('', $t[1]);
                    }, $xml);

                    $xml = preg_replace_callback('/<m:oMath[^>]*>(.*?)<\/m:oMath>/is', function ($m) {
                        preg_match_all('/<m:t[^>]*>(.*?)<\/m:t>/is', $m[1], $t);
                        return implode('', $t[1]);
                    }, $xml);

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

                if ($request->question_type == 'MCQ') {

                    for ($i = 0; $i < count($tables); $i++) {
                        $questionData = [];
                        $option_b = NULL;
                        $option_c = NULL;
                        $option_a = NULL;
                        $option_d = NULL;
                        $option_e = NULL;
                        $image = NULL;
                        $solution = NULL;
                        $answer = NULL;
                        $instruction = NULL;
                        $has_option_e = false;
                        $has_solution = "no";
                        $has_instruction = false;
                        $show_on_pyq = 'no';

                        try {
                            $qTr = $tables[$i]->find('tr', 0);
                            $qTd = $qTr ? $qTr->find('td', 1) : null;
                            $question = $qTd ? $this->normalizeParagraphSpacing($qTd->innerHtml) : null;

                            if ($question === null) {
                                throw new \Exception('Missing question row');
                            }

                            $rawA = $this->getCellHtml($tables[$i], 1);
                            $option_a = $this->isEmptyCell($rawA) ? null : $this->normalizeParagraphSpacing($rawA);

                            $rawB = $this->getCellHtml($tables[$i], 2);
                            $option_b = $this->isEmptyCell($rawB) ? null : $this->normalizeParagraphSpacing($rawB);

                            $rawC = $this->getCellHtml($tables[$i], 3);
                            $option_c = $this->isEmptyCell($rawC) ? null : $this->normalizeParagraphSpacing($rawC);

                            $rawD = $this->getCellHtml($tables[$i], 4);
                            $option_d = $this->isEmptyCell($rawD) ? null : $this->normalizeParagraphSpacing($rawD);

                            $rejectQuestion = false;
                            $rejectNote = '';

                            // Option E (optional) - ROW 5
                            $rawE = $this->getCellHtml($tables[$i], 5);
                            if ($this->isEmptyCell($rawE)) {
                                $option_e = null;
                                $has_option_e = false;
                            } else {
                                $option_e = $this->normalizeParagraphSpacing($rawE);
                                $has_option_e = true;
                            }

                            // Answer (mandatory) - ROW 6
                            $rawAnswer = $this->getCellHtml($tables[$i], 6);
                            $answer = $this->isEmptyCell($rawAnswer)
                                ? null
                                : trim(strip_tags(html_entity_decode($rawAnswer, ENT_QUOTES | ENT_HTML5, 'UTF-8')));

                            if ($answer === null || $answer === '' || $answer === '&nbsp;') {
                                $rejectQuestion = true;
                                $rejectNote = 'Answer missing or unreadable (Row 6)';
                                $answer = $answer ?: '';
                            }


                            // Instruction (optional) - ROW 7
                            $rawInstr = $this->getCellHtml($tables[$i], 7);
                            if ($this->isEmptyCell($rawInstr)) {
                                $instruction = null;
                                $has_instruction = false;
                            } else {
                                $tr7 = $tables[$i]->find('tr', 7);
                                $td7 = $tr7 ? $tr7->find('td', 1) : null;
                                $instruction = $td7 ? $this->normalizeParagraphSpacing($td7->innerHtml) : null;
                                $has_instruction = true;
                            }

                            // Solution (optional) - ROW 8
                            $rawSol = $this->getCellHtml($tables[$i], 8);
                            if (!$this->isEmptyCell($rawSol)) {
                                $solution = $this->normalizeParagraphSpacing($rawSol);
                                $has_solution = 'yes';
                            }

                            // PYQ (optional) - ROW 9
                            $rawPyq = $this->getCellHtml($tables[$i], 9);
                            $textPyq = strtolower(trim(strip_tags(html_entity_decode($rawPyq ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
                            $show_on_pyq = ($textPyq === 'yes') ? 'yes' : 'no';

                            // Finally, set status once
                            if ($rejectQuestion) {
                                $questionData['status'] = 'Rejected';
                                $questionData['note'] = $rejectNote;
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
                            $questionData['option_a'] = $option_a;
                            $questionData['option_b'] = $option_b;
                            $questionData['option_c'] = $option_c;
                            $questionData['option_d'] = $option_d;
                            $questionData['option_e'] = $option_e;
                            $questionData['image'] = $image;
                            $questionData['answer'] = strtoupper(Str::of($answer)->trim());
                            $questionData['has_solution'] = $has_solution;
                            $questionData['solution'] = $solution;
                            $questionData['show_on_pyq'] = $show_on_pyq;
                            $questionData['added_by_id'] = auth()->id(); // Logged in teacher/user
                            $questionData['added_by_type'] = 'teacher';
                            $questionData['status'] = 'Pending';

                            if (!$rejectQuestion) {
                                $que = Question::where('question', $question)
                                    ->where('commission_id', $request->commission_id)
                                    ->where('category_id', $request->category_id)
                                    ->where('sub_category_id', $request->sub_category_id)
                                    ->where('subject_id', $request->subject_id);
                                if ($request->previous_year) {
                                    $que = $que->where('previous_year', $request->previous_year);
                                }
                                $que = $que->first();

                                if ($que) {
                                    $questionData['status'] = "Rejected";
                                    $questionData['note'] = "Already Exists Question.";
                                }
                            }

                            Question::create($questionData);
                        } catch (\Exception $ex) {
                            $qTr = $tables[$i]->find('tr', 0);
                            $qTd = $qTr ? $qTr->find('td', 1) : null;
                            $question = $qTd ? $this->normalizeParagraphSpacing($qTd->innerHtml) : null;

                            $questionData['status'] = "Rejected";
                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue: ' . $ex->getMessage();
                            Question::create($questionData);
                        }
                    }
                } elseif ($request->question_type == 'Subjective') {

                    for ($i = 1; $i < count($tables); $i++) {
                        $questionData = [];
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
                        $show_on_pyq = 'no';

                        try {
                            $qTr = $tables[$i]->find('tr', 0);
                            $qTd = $qTr ? $qTr->find('td', 1) : null;
                            $question = $qTd ? $this->normalizeParagraphSpacing($qTd->innerHtml) : null;

                            if ($question === null) {
                                throw new \Exception('Missing question row');
                            }

                            // Image (optional) - ROW 1
                            $tr1 = $tables[$i]->find('tr', 1);
                            $td1 = $tr1 ? $tr1->find('td', 1) : null;
                            $imageElement = null;
                            if ($td1) {
                                $imgs = $td1->find('img');
                                if ($imgs && count($imgs) > 0) {
                                    $imageElement = $imgs[0];
                                }
                            }

                            if ($imageElement) {
                                $image_64 = $imageElement->src;
                                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                                $image = 'question/' . Str::random(40) . '.' . $extension;
                                Storage::put($image, file_get_contents($image_64));
                            } else {
                                $image = NULL;
                            }

                            // Answer format (mandatory-ish) - ROW 2
                            $rawFormat = $this->getCellHtml($tables[$i], 2);
                            $answer_format = $this->isEmptyCell($rawFormat) ? "text input" : $rawFormat;

                            // Solution (optional) - ROW 3
                            $rawSol = $this->getCellHtml($tables[$i], 3);
                            if ($this->isEmptyCell($rawSol)) {
                                $solution = null;
                                $has_solution = 'no';
                            } else {
                                $solution = $this->normalizeParagraphSpacing($rawSol);
                                $has_solution = 'yes';
                            }

                            // Instruction (optional) - ROW 4
                            $rawInstr = $this->getCellHtml($tables[$i], 4);
                            if ($this->isEmptyCell($rawInstr)) {
                                $instruction = NULL;
                                $has_instruction = false;
                            } else {
                                $tr4 = $tables[$i]->find('tr', 4);
                                $td4 = $tr4 ? $tr4->find('td', 1) : null;
                                $instruction = $td4 ? $this->normalizeParagraphSpacing($td4->innerHtml) : null;
                                $has_instruction = true;
                            }

                            // PYQ (optional) - ROW 5
                            $rawPyq = $this->getCellHtml($tables[$i], 5);
                            $textPyq = strtolower(trim(strip_tags(html_entity_decode($rawPyq ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
                            $show_on_pyq = ($textPyq === 'yes') ? 'yes' : 'no';

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
                            $questionData['show_on_pyq'] = $show_on_pyq;
                            $questionData['added_by_id'] = auth()->id(); // Logged in teacher/user
                            $questionData['added_by_type'] = 'teacher';
                            $questionData['status'] = 'Pending';

                            $que = Question::where('question', $question)
                                ->where('commission_id', $request->commission_id)
                                ->where('category_id', $request->category_id)
                                ->where('sub_category_id', $request->sub_category_id)
                                ->where('subject_id', $request->subject_id);
                            if ($request->previous_year) {
                                $que = $que->where('previous_year', $request->previous_year);
                            }
                            $que = $que->first();

                            if (!$answer_format) {
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Please enter Answer format";
                            } elseif ($que) {
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Already Exists Question.";
                            } else {
                                $questionData['status'] = 'Done';
                            }

                            Question::create($questionData);
                        } catch (\Exception $ex) {
                            $qTr = $tables[$i]->find('tr', 0);
                            $qTd = $qTr ? $qTr->find('td', 1) : null;
                            $question = $qTd ? $this->normalizeParagraphSpacing($qTd->innerHtml) : null;

                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue: ' . $ex->getMessage();
                            $questionData['status'] = "Rejected";
                            Question::create($questionData);
                        }
                    }
                } elseif ($request->question_type == 'Story Based') {
                    $questionData = [];
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
                    $show_on_pyq = 'no';

                    if (!isset($tables[1])) {
                        throw new \Exception('Invalid Story Based document format');
                    }

                    $qTr = $tables[1]->find('tr', 0);
                    $qTd = $qTr ? $qTr->find('td', 1) : null;
                    $question = $qTd ? $this->normalizeParagraphSpacing($qTd->innerHtml) : null;

                    // Image (optional) - ROW 1
                    $tr1 = $tables[1]->find('tr', 1);
                    $td1 = $tr1 ? $tr1->find('td', 1) : null;
                    $imageElement = null;
                    if ($td1) {
                        $imgs = $td1->find('img');
                        if ($imgs && count($imgs) > 0) {
                            $imageElement = $imgs[0];
                        }
                    }

                    if ($imageElement) {
                        $image_64 = $imageElement->src;
                        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                        $image = 'question/' . Str::random(40) . '.' . $extension;
                        Storage::put($image, file_get_contents($image_64));
                    } else {
                        $image = NULL;
                    }

                    // Instruction (optional) - ROW 2
                    $rawInstr = $this->getCellHtml($tables[1], 2);
                    if ($this->isEmptyCell($rawInstr)) {
                        $instruction = NULL;
                        $has_instruction = false;
                    } else {
                        $tr2 = $tables[1]->find('tr', 2);
                        $td2 = $tr2 ? $tr2->find('td', 1) : null;
                        $instruction = $td2 ? $this->normalizeParagraphSpacing($td2->innerHtml) : null;
                        $has_instruction = true;
                    }

                    // PYQ (Story Based - Passage level) - ROW 3
                    $rawPyq = $this->getCellHtml($tables[1], 3);
                    $textPyq = strtolower(trim(strip_tags(html_entity_decode($rawPyq ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
                    $show_on_pyq = ($textPyq === 'yes') ? 'yes' : 'no';

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
                    $questionData['answer_format'] = null;
                    $questionData['has_solution'] = $has_solution;
                    $questionData['instruction'] = $instruction;
                    $questionData['has_instruction'] = $has_instruction;
                    $questionData['show_on_pyq'] = $show_on_pyq;
                    $questionData['added_by_id'] = auth()->id(); // Logged in teacher/user
                    $questionData['added_by_type'] = 'teacher';
                    $questionData['status'] = 'Pending';


                    $que = Question::where('question', $question)
                        ->where('commission_id', $request->commission_id)
                        ->where('category_id', $request->category_id)
                        ->where('sub_category_id', $request->sub_category_id)
                        ->where('subject_id', $request->subject_id);
                    if ($request->previous_year) {
                        $que = $que->where('previous_year', $request->previous_year);
                    }
                    $que = $que->first();

                    if ($que) {
                        $questionData['status'] = "Rejected";
                        $questionData['note'] = "Already Exists Question.";
                    } else {
                        $questionData['status'] = 'Done';
                    }

                    $ques = Question::create($questionData);

                    if ($ques) {
                        for ($i = 2; $i < count($tables); $i++) {
                            try {
                                $tr4 = $tables[$i]->find('tr', 4);
                                if (!$tr4) {
                                    // Subjective sub-question
                                    $pqTr = $tables[$i]->find('tr', 0);
                                    $pqTd = $pqTr ? $pqTr->find('td', 1) : null;
                                    $passage_question = $pqTd ? $this->normalizeParagraphSpacing($pqTd->innerHtml) : null;

                                    // Answer format - ROW 1
                                    $rawAf = $this->getCellHtml($tables[$i], 1);
                                    $passage_answer_format = $this->isEmptyCell($rawAf)
                                        ? null
                                        : trim(str_replace("\xc2\xa0", '', strip_tags(html_entity_decode($rawAf, ENT_QUOTES | ENT_HTML5, 'UTF-8'))));

                                    // Solution - ROW 2
                                    $rawSol = $this->getCellHtml($tables[$i], 2);
                                    $detail_solution = $this->isEmptyCell($rawSol) ? null : $this->normalizeParagraphSpacing($rawSol);

                                    $question_detail = [
                                        'question_id' => $ques->id,
                                        'question' => $passage_question,
                                        'answer_format' => $passage_answer_format,
                                        'type' => 'reasoning'
                                    ];

                                    if ($detail_solution !== null) {
                                        $question_detail['solution'] = $detail_solution;
                                    }

                                    QuestionDetail::create($question_detail);
                                } else {
                                    // MCQ sub-question
                                    $pqTr = $tables[$i]->find('tr', 0);
                                    $pqTd = $pqTr ? $pqTr->find('td', 1) : null;
                                    $passage_question = $pqTd ? $this->normalizeParagraphSpacing($pqTd->innerHtml) : null;

                                    $rawA = $this->getCellHtml($tables[$i], 1);
                                    $option_a = $this->isEmptyCell($rawA) ? null : $this->normalizeParagraphSpacing($rawA);

                                    $rawB = $this->getCellHtml($tables[$i], 2);
                                    $option_b = $this->isEmptyCell($rawB) ? null : $this->normalizeParagraphSpacing($rawB);

                                    $rawC = $this->getCellHtml($tables[$i], 3);
                                    $option_c = $this->isEmptyCell($rawC) ? null : $this->normalizeParagraphSpacing($rawC);

                                    $rawD = $this->getCellHtml($tables[$i], 4);
                                    $option_d = $this->isEmptyCell($rawD) ? null : $this->normalizeParagraphSpacing($rawD);

                                    $rawE = $this->getCellHtml($tables[$i], 5);
                                    if ($this->isEmptyCell($rawE)) {
                                        $option_e = null;
                                        $has_option_e = false;
                                    } else {
                                        $option_e = $this->normalizeParagraphSpacing($rawE);
                                        $has_option_e = true;
                                    }

                                    $rawAnswer = $this->getCellHtml($tables[$i], 6);
                                    $passage_answer = $rawAnswer ?? '';

                                    // Solution - ROW 7, fallback ROW 8
                                    $detail_solution = null;
                                    $rawSol7 = $this->getCellHtml($tables[$i], 7);
                                    if (!$this->isEmptyCell($rawSol7)) {
                                        $detail_solution = $this->normalizeParagraphSpacing($rawSol7);
                                    } else {
                                        $rawSol8 = $this->getCellHtml($tables[$i], 8);
                                        if (!$this->isEmptyCell($rawSol8)) {
                                            $detail_solution = $this->normalizeParagraphSpacing($rawSol8);
                                        }
                                    }

                                    $question_detail = [
                                        'question_id' => $ques->id,
                                        'question' => $passage_question,
                                        'answer' => strtoupper(Str::of(strip_tags($passage_answer))->trim()),
                                        'option_a' => $option_a,
                                        'option_b' => $option_b,
                                        'option_c' => $option_c,
                                        'option_d' => $option_d,
                                        'option_e' => $option_e,
                                        'has_option_e' => $has_option_e,
                                        'type' => 'mcq'
                                    ];
                                    if ($detail_solution !== NULL) {
                                        $question_detail['solution'] = $detail_solution;
                                    }
                                    QuestionDetail::create($question_detail);
                                }
                            } catch (\Exception $ex) {
                                // Log but don't kill the whole passage import over one sub-question
                                \Log::warning('Story Based sub-question format issue: ' . $ex->getMessage());
                            }
                        }
                    }
                }

                DB::commit();
                return redirect()->route('question.bank.index')->with('success', 'Questions created successfully.');
            } else {
                $import = new QuestionsImport($request->all());
                $import->import($request->file);
                DB::commit();
                return redirect()->route('question.bank.index')->with('success', 'Questions created successfully.');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('question.bank.bulk-upload')->with('error', 'Something went wrong: ' . $ex->getMessage());
        }
    }

    private function normalizeParagraphSpacing($html)
    {
        if (!$html) {
            return $html;
        }

        // Strip Word's injected margin/spacing styles on <p> tags so
        // consecutive paragraphs (e.g. "Conclusions:" then "1. ...")
        // don't render with large gaps that make the content look empty.
        $html = preg_replace('/<p([^>]*)style="[^"]*"([^>]*)>/i', '<p$1$2>', $html);

        // Collapse consecutive empty paragraphs (e.g. <p>&nbsp;</p>)
        $html = preg_replace('/(<p[^>]*>(\s|&nbsp;)*<\/p>)+/i', '', $html);

        return $html;
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
