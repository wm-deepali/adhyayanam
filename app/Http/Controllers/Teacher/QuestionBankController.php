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
                    ->whereIn('status', ['Pending', 'Done']) // 🔹 Include both Pending and Done
                    ->where('added_by_id', $teacherId) // 🔹 Filter by logged-in teacher
                    ->latest()->paginate(10);

                return view('teachers.question-bank.question-table')->with([
                    'questionBanks' => $questions
                ]);
            } else {
                $data['commissions'] = ExaminationCommission::get();
                $data['questionBanks'] = Question::whereIn('status', ['Pending', 'Done'])
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
            ->get();

        return view('teachers.question-bank.rejected', $data);
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
        //dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'previous_year' => 'nullable|integer',
            'commission_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'subject_id' => 'required',
            'chapter_id' => 'nullable',
            'topic' => 'nullable',
            'has_instruction' => 'nullable',
            'instruction' => 'nullable',
            'has_option_e' => 'nullable',
            'question.*' => 'required_if:question_type,MCQ',
            'answer.*' => 'required_if:question_type,MCQ',
            'option_a.*' => 'required_if:question_type,MCQ',
            'option_b.*' => 'required_if:question_type,MCQ',
            'option_c.*' => 'required_if:question_type,MCQ',
            'option_d.*' => 'required_if:question_type,MCQ',
            'option_e.*' => 'nullable|string',
            'passage_question_type' => 'required_if:question_type,Story Based',
        ]);



        // Process and save each question associated with this question bank
        foreach ($request->question as $key => $questionData) {
            if (isset($questionData) && $questionData != "") {


                // QuestionBank::where('id',$questionBank->id)->update(['question' => $questionData]);
                // Create a new instance of Question model
                $question = new Question();

                // Assign values to the model properties
                $question->language = $request->language;
                $question->question_category = $request->question_category;
                $question->question_type = $request->question_type;
                $question->fee_type = $request->fee_type;
                $question->previous_year = $request->previous_year;
                $question->commission_id = $request->commission_id;
                $question->category_id = $request->category_id;
                $question->sub_category_id = $request->sub_category_id;
                $question->chapter_id = $request->chapter_id;
                $question->subject_id = $request->subject_id;
                $question->topic = $request->topic;
                $question->has_instruction = $request->has_instruction ? true : false;
                $question->instruction = $request->has_instruction ? $request->instruction : null;
                $question->has_option_e = $request->has_option_e ? true : false;
                $question->show_on_pyq = $request->show_on_pyq == "yes" ? "yes" : "no";
                // $question->question_bank_id = $questionBank->id; // Assign the question bank ID
                $question->question = $questionData;
                $question->answer = $request->answer[$key] ?? NULL;
                $question->option_a = $request->option_a[$key] ?? NULL;
                $question->option_b = $request->option_b[$key] ?? NULL;
                $question->option_c = $request->option_c[$key] ?? NULL;
                $question->option_d = $request->option_d[$key] ?? NULL;
                $question->option_e = $request->has_option_e ? $request->option_e[$key] ?? null : null;

                $question->passage_question_type = $request->passage_question_type ?? NULL;
                $question->answer_format = $request->answer_format[$key] ?? NULL;
                $question->has_solution = (isset($request->hasFile('answerformatsolution')[$key])) ? 'yes' : 'no';
                $question->solution = isset(($request->hasFile('answerformatsolution')[$key])) ? $request->answerformatsolution->store('answerformatsolution')[$key] : NULL;
                // Save the question to the database

                // Assign the teacher who added the question
                $question->added_by_id = auth()->id(); // teacher's ID
                $questionData['added_by_type'] = 'teacher';
                // Set default status
                $question->status = 'pending';

                $question->save();

                if (isset($request->question_type) && $request->question_type == 'Story Based') {

                    if ($request->passage_question_type == 'reasoning_subjective') {
                        foreach ($request->reasoning_passage_questions as $t => $passagequestionData) {
                            if (isset($passagequestionData) && $passagequestionData != "") {

                                QuestionDetail::create([
                                    'question_id' => $question->id,
                                    'question' => $passagequestionData,
                                ]);

                            }

                        }
                    }
                    if ($request->passage_question_type == 'multiple_choice') {

                        foreach ($request->passage_mcq_questions as $k => $passagemcqquestionData) {
                            if (isset($passagemcqquestionData) && $passagemcqquestionData != "") {


                                QuestionDetail::create([
                                    'question_id' => $question->id,
                                    'question' => $passagemcqquestionData,
                                    'answer' => strtoupper($request->multiple_choice_passage_answer[$k]) ?? NULL,
                                    'option_a' => $request->multiple_choice_passage_option_a[$k],
                                    'option_b' => $request->multiple_choice_passage_option_b[$k],
                                    'option_c' => $request->multiple_choice_passage_option_c[$k],
                                    'option_d' => $request->multiple_choice_passage_option_d[$k],
                                ]);
                            }
                        }
                    }

                }
            }

        }

        // Optionally, you can redirect the user after successful submission
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
        //dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'previous_year' => 'nullable|integer',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'subject_id' => 'required',
            'chapter_id' => 'nullable',
            'topic' => 'nullable',
            'has_instruction' => 'nullable',
            'instruction' => 'nullable',
            'has_option_e' => 'nullable',
            'question.*' => 'required_if:question_type,MCQ',
            'answer.*' => 'required_if:question_type,MCQ',
            'option_a.*' => 'required_if:question_type,MCQ',
            'option_b.*' => 'required_if:question_type,MCQ',
            'option_c.*' => 'required_if:question_type,MCQ',
            'option_d.*' => 'required_if:question_type,MCQ',
            'option_e.*' => 'nullable|string',
            'passage_question_type' => 'required_if:question_type,Story Based',
        ]);

        // Process and save each question associated with this question bank
        foreach ($request->question as $key => $questionData) {
            if (isset($questionData) && $questionData != "") {
                // QuestionBank::where('id',$questionBank->id)->update(['question' => $questionData]);
                // Create a new instance of Question model
                $question = Question::find($id);

                // Assign values to the model properties
                $question->language = $request->language;
                $question->question_category = $request->question_category;
                $question->question_type = $request->question_type;
                $question->fee_type = $request->fee_type;
                $question->commission_id = $request->commission_id;
                $question->previous_year = $request->previous_year;
                $question->category_id = $request->category_id;
                $question->sub_category_id = $request->sub_category_id;
                $question->chapter_id = $request->chapter_id;
                $question->subject_id = $request->subject_id;
                $question->topic = $request->topic;
                $question->has_instruction = $request->has_instruction ? true : false;
                $question->instruction = $request->has_instruction ? $request->instruction : null;
                $question->has_option_e = $request->has_option_e ? true : false;
                $question->show_on_pyq = $request->show_on_pyq == "yes" ? "yes" : "no";
                // $question->question_bank_id = $questionBank->id; // Assign the question bank ID
                $question->question = $questionData;
                $question->answer = $request->answer[$key] ?? NULL;
                $question->option_a = $request->option_a[$key] ?? NULL;
                $question->option_b = $request->option_b[$key] ?? NULL;
                $question->option_c = $request->option_c[$key] ?? NULL;
                $question->option_d = $request->option_d[$key] ?? NULL;
                $question->option_e = $request->has_option_e ? $request->option_e[$key] ?? null : null;
                $question->passage_question_type = $request->passage_question_type ?? NULL;
                $question->answer_format = $request->answer_format[$key] ?? NULL;
                $question->has_solution = (isset($request->hasFile('answerformatsolution')[$key])) ? 'yes' : 'no';
                $question->solution = isset(($request->hasFile('answerformatsolution')[$key])) ? $request->answerformatsolution->store('answerformatsolution')[$key] : NULL;

                // Save the question to the database
                $question->save();


                if (isset($request->question_type) && $request->question_type == 'Story Based') {
                    QuestionDetail::where('question_id', $question->id)->delete();
                    if ($request->passage_question_type == 'reasoning_subjective') {
                        foreach ($request->reasoning_passage_questions as $t => $passagequestionData) {
                            if (isset($passagequestionData) && $passagequestionData != "") {

                                QuestionDetail::create([
                                    'question_id' => $question->id,
                                    'question' => $passagequestionData,
                                ]);

                            }

                        }
                    }
                    if ($request->passage_question_type == 'multiple_choice') {

                        foreach ($request->passage_mcq_questions as $k => $passagemcqquestionData) {
                            if (isset($passagemcqquestionData) && $passagemcqquestionData != "") {


                                QuestionDetail::create([
                                    'question_id' => $question->id,
                                    'question' => $passagemcqquestionData,
                                    'answer' => strtoupper($request->multiple_choice_passage_answer[$k]) ?? NULL,
                                    'option_a' => $request->multiple_choice_passage_option_a[$k],
                                    'option_b' => $request->multiple_choice_passage_option_b[$k],
                                    'option_c' => $request->multiple_choice_passage_option_c[$k],
                                    'option_d' => $request->multiple_choice_passage_option_d[$k],
                                ]);
                            }
                        }
                    }

                }
                // QuestionBank::where('id', $questionBank->id)->update(['question' => $questionData]);
            }
        }

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('teacher.question.bank.index')->with('success', 'Questions updated successfully.');
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
                            if ($tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_e = NULL;
                                $has_option_e = false;
                            } else {
                                $option_e = $tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml;
                                $has_option_e = true;
                            }

                            if ($tables[$i]->find('tr', 6)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $answer = NULL;
                            } else {
                                $answer = $tables[$i]->find('tr', 6)->find('td', 1)->find('p')->find('span')->innerHtml;
                            }

                            if ($tables[$i]->find('tr', 7)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $instruction = NULL;
                                $has_instruction = false;
                            } else {
                                $instruction = $tables[$i]->find('tr', 7)->find('td', 1)->innerHtml;
                                $has_instruction = true;
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
                            if ($tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $solution = NULL;
                                $has_solution = 'no';
                            } else {
                                $solution = $tables[$i]->find('tr', 3)->find('td', 1)->innerHtml;
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
                        if ($tables[1]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                            $solution = NULL;
                            $has_solution = 'no';
                        } else {
                            $solution = $tables[1]->find('tr', 2)->find('td', 1)->innerHtml;
                            $has_solution = 'yes';
                        }
                        if ($tables[1]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                            $instruction = NULL;
                            $has_instruction = false;
                        } else {
                            $instruction = $tables[1]->find('tr', 3)->find('td', 1)->innerHtml;
                            $has_instruction = true;
                        }
                        if ($request->passage_question_type == 'reasoning_subjective') {
                            $answer_format = NULL;
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
                                    $question_detail = ([
                                        'question_id' => $ques->id,
                                        'question' => $passage_question,
                                        'answer_format' => $passage_answer_format,
                                    ]);
                                    QuestionDetail::create($question_detail);
                                } else {
                                    $passage_question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                                    $option_a = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml;
                                    $option_b = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                                    $option_c = $tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml;
                                    $option_d = $tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml;
                                    if ($tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                        $option_e = NULL;
                                        $has_option_e = false;
                                    } else {
                                        $option_e = $tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml;
                                        $has_option_e = true;
                                    }
                                    $passage_answer = $tables[$i]->find('tr', 6)->find('td', 1)->find('p')->innerHtml;
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
