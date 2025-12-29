<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExaminationCommission;
use App\Models\SubCategory;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherExamMapping;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teachers = Teacher::select('teachers.*');
            // dd('here');
            return Datatables::of($teachers)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($teacher) {
                    return '<input type="checkbox" class="column_checkbox" value="' . $teacher->id . '">';
                })

                ->addColumn('profile_picture', function ($teacher) {
                    $url = $teacher->profile_picture ? asset('storage/' . $teacher->profile_picture) : asset('images/default-avatar.png');
                    return '<img src="' . $url . '" class="rounded-circle" width="50" height="50">';
                })
                ->addColumn('teacher_name', function ($teacher) {
                    return $teacher->full_name;
                })
                ->addColumn('mobile_number', function ($teacher) {
                    return $teacher->mobile_number;
                })
                ->addColumn('email', function ($teacher) {
                    return $teacher->email;
                })
                ->addColumn('total_questions', function ($teacher) {
                    return $teacher->total_questions_count ?? 0;
                })
                ->addColumn('wallet_balance', function ($teacher) {
                    return number_format($teacher->wallet_balance, 2);
                })
                ->addColumn('total_paid', function ($teacher) {
                    return number_format($teacher->total_paid_amount, 2);
                })
                ->addColumn('created_by', function ($row) {
                    return $row->creator
                        ? $row->creator->name
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('status', function ($teacher) {
                    return $teacher->status ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function ($teacher) {

                    $items = '';

                    // VIEW PROFILE
                    if (\App\Helpers\Helper::canAccess('manage_teachers')) {
                        $items .= '
        <li>
            <a class="dropdown-item text-primary"
               href="' . route("manage-teachers.show", $teacher->id) . '">
                <i class="fas fa-user me-2"></i> View Profile
            </a>
        </li>';
                    }

                    // VIEW WALLET
                    if (\App\Helpers\Helper::canAccess('manage_teacher_wallet')) {
                        $items .= '
        <li>
            <a class="dropdown-item text-success"
               href="' . route("teacher.wallet.index", ['teacher_id' => $teacher->id]) . '">
                <i class="fas fa-wallet me-2"></i> View Wallet
            </a>
        </li>';
                    }

                    // VIEW QUESTIONS
                    if (\App\Helpers\Helper::canAccess('manage_question_bank')) {
                        $items .= '
        <li>
            <a class="dropdown-item text-info"
               href="' . route("question.bank.index", ['teacher_id' => $teacher->id]) . '">
                <i class="fas fa-question-circle me-2"></i> View All Questions
            </a>
        </li>';
                    }

                    // VIEW PAYOUTS
                    if (\App\Helpers\Helper::canAccess('manage_withdrawal_requests')) {
                        $items .= '
        <li>
            <a class="dropdown-item text-warning"
               href="' . route("withdrawal.requests.index", ['teacher_id' => $teacher->id]) . '">
                <i class="fas fa-money-check me-2"></i> View Payouts
            </a>
        </li>';
                    }

                    // EDIT
                    if (\App\Helpers\Helper::canAccess('manage_teachers_edit')) {
                        $items .= '
        <li>
            <a class="dropdown-item text-secondary"
               href="' . route("manage-teachers.edit", $teacher->id) . '">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
        </li>

        <li>
            <button class="dropdown-item text-dark btn-change-password"
                    data-id="' . $teacher->id . '"
                    data-name="' . e($teacher->full_name) . '">
                <i class="fas fa-key me-2"></i> Change Password
            </button>
        </li>';
                    }

                    // DELETE
                    if (\App\Helpers\Helper::canAccess('manage_teachers_delete')) {
                        $items .= '
        <li>
            <form action="' . route('manage-teachers.delete', $teacher->id) . '"
                  method="POST"
                  onsubmit="return confirm(\'Are you sure?\')">
                ' . csrf_field() . '
                ' . method_field("DELETE") . '
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash me-2" style="color:red!important;"></i> Delete
                </button>
            </form>
        </li>';
                    }

                    // NO PERMISSION → NO DROPDOWN
                    if ($items === '') {
                        return '-';
                    }

                    return '
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu">
            ' . $items . '
        </ul>
    </div>';
                })


                ->rawColumns(['checkbox', 'profile_picture', 'status', 'action', 'created_by'])
                ->make(true);
        }
        return view('admin.teachers.index');
    }

    // Show single teacher profile
    public function show(Teacher $teacher)
    {
        $teacher->load('examMappings.examType', 'examMappings.category', 'examMappings.subCategory', 'examMappings.subject');
        // dd($teacher->toArray());
        return view('admin.teachers.show', compact('teacher'));
    }

    // Show create teacher form
    public function create()
    {

        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];
        $data['categories'] = [];

        return view('admin.teachers.create', $data);
    }

    public function store(Request $request)
    {
        /* ===============================
         |  VALIDATION
         =============================== */
        $validator = Validator::make($request->all(), [

            /* -------- Personal Info -------- */
            'full_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:teachers,email',
            'mobile_number' => 'required|digits:10',
            'whatsapp_number' => 'nullable|digits:10',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
            'highest_qualification' => 'nullable|string|max:255',
            'total_experience' => 'nullable|numeric|min:0|max:60',

            /* -------- Address -------- */
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'pin_code' => 'nullable|digits_between:4,10',

            /* -------- Password -------- */
            'password' => 'required|string|min:6|confirmed',

            /* -------- Language -------- */
            'language' => 'nullable|array',
            'language.*' => 'in:1,2',

            /* -------- Permissions -------- */
            'can_conduct_live_classes' => 'nullable|boolean',
            'can_check_tests' => 'nullable|boolean',

            /* -------- Question Type -------- */
            'question_type_permission' => 'nullable|array',
            'question_type_permission.*' => 'in:MCQ,Subjective,Story / Passage-Based',

            'pay_per_question' => 'nullable|array',
            'pay_per_question.MCQ' => 'nullable|numeric|min:0',
            'pay_per_question.Subjective' => 'nullable|numeric|min:0',
            'pay_per_question.Story / Passage-Based' => 'nullable|numeric|min:0',

            /* -------- Account Setup -------- */
            'exam_type' => 'required|array|min:1',
            'exam_type.*' => 'required|exists:exam_commissions,id',

            'category' => 'nullable|array',
            'category.*' => 'nullable|exists:exam_categories,id',

            'sub_category' => 'nullable|array',
            'sub_category.*' => 'nullable|exists:exam_sub_categories,id',

            'subject' => 'nullable|array',
            'subject.*' => 'nullable|exists:subjects,id',

            /* -------- Bank -------- */
            'upi_id' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:30',
            'confirm_account_number' => 'nullable|same:account_number',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'nullable|string|max:20',

            /* -------- Files -------- */
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'pan_file' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'aadhar_front' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'aadhar_back' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'cancelled_cheque' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'qr_code' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'education_docs' => 'nullable|array',
            'education_docs.*' => 'mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            'pan_number' => 'nullable|string|max:20',
            'aadhar_number' => 'nullable|digits:12',


        ]);

        /* ===============================
         |  CONDITIONAL VALIDATION
         =============================== */
        $validator->after(function ($validator) use ($request) {

            $permissions = $request->question_type_permission ?? [];

            if (
                in_array('MCQ', $permissions) &&
                empty($request->pay_per_question['MCQ'])
            ) {
                $validator->errors()->add('pay_per_question.MCQ', 'Pay per MCQ is required.');
            }

            if (
                in_array('Subjective', $permissions) &&
                empty($request->pay_per_question['Subjective'])
            ) {
                $validator->errors()->add('pay_per_question.Subjective', 'Pay per Subjective is required.');
            }

            if (
                in_array('Story / Passage-Based', $permissions) &&
                empty($request->pay_per_question['Story / Passage-Based'])
            ) {
                $validator->errors()->add('pay_per_question.Story / Passage-Based', 'Pay per Story is required.');
            }

            if (!$request->subject || collect($request->subject)->filter()->isEmpty()) {
                $validator->errors()->add('subject', 'At least one subject must be selected.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        /* ===============================
         |  SAVE DATA (TRANSACTION)
         =============================== */
        DB::transaction(function () use ($request) {

            $teacher = new Teacher();

            /* -------- Personal -------- */
            $teacher->full_name = $request->full_name;
            $teacher->email = $request->email;
            $teacher->mobile_number = $request->mobile_number;
            $teacher->whatsapp_number = $request->whatsapp_number;
            $teacher->gender = $request->gender;
            $teacher->dob = $request->dob;
            $teacher->highest_qualification = $request->highest_qualification;
            $teacher->total_experience = $request->total_experience;
            $teacher->full_address = $request->address;
            $teacher->country = $request->country;
            $teacher->state = $request->state;
            $teacher->city = $request->city;
            $teacher->pin_code = $request->pin_code;

            $teacher->can_conduct_live_classes = $request->has('can_conduct_live_classes');
            $teacher->can_check_tests = $request->has('can_check_tests');
            $teacher->allow_languages = $request->language ?? [];

            $teacher->password = Hash::make($request->password);

            /* -------- Question Permissions -------- */
            $permissions = $request->question_type_permission ?? [];
            $payments = $request->pay_per_question ?? [];

            $teacher->allow_mcq = in_array('MCQ', $permissions);
            $teacher->allow_subjective = in_array('Subjective', $permissions);
            $teacher->allow_story = in_array('Story / Passage-Based', $permissions);

            $teacher->pay_per_mcq = $payments['MCQ'] ?? 0;
            $teacher->pay_per_subjective = $payments['Subjective'] ?? 0;
            $teacher->pay_per_story = $payments['Story / Passage-Based'] ?? 0;

            /* -------- Bank -------- */
            $teacher->upi_id = $request->upi_id;
            $teacher->account_name = $request->account_name;
            $teacher->account_number = $request->account_number;
            $teacher->bank_name = $request->bank_name;
            $teacher->bank_branch = $request->bank_branch;
            $teacher->ifsc_code = $request->ifsc_code;
            $teacher->swift_code = $request->swift_code;
            $teacher->pan_number = $request->pan_number;
            $teacher->aadhar_number = $request->aadhar_number;

            $teacher->created_by = auth()->id();

            /* -------- Files -------- */
            $fileFields = [
                'profile_picture' => 'teachers/profile_pictures',
                'cv' => 'teachers/cv',
                'pan_file' => 'teachers/pan',
                'aadhar_front' => 'teachers/aadhar',
                'aadhar_back' => 'teachers/aadhar',
                'cancelled_cheque' => 'teachers/bank',
                'qr_code' => 'teachers/bank',
            ];

            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    $teacher->$field = $request->file($field)->store($path, 'public');
                }
            }

            if ($request->hasFile('education_docs')) {
                $docs = [];
                foreach ($request->file('education_docs') as $file) {
                    $docs[] = $file->store('teachers/education_docs', 'public');
                }
                $teacher->education_docs = json_encode($docs);
            }

            $teacher->save();

            /* -------- Exam Mapping -------- */
            foreach ($request->exam_type as $index => $examTypeId) {
                TeacherExamMapping::create([
                    'teacher_id' => $teacher->id,
                    'exam_type_id' => $examTypeId,
                    'category_id' => $request->category[$index] ?? null,
                    'sub_category_id' => $request->sub_category[$index] ?? null,
                    'subject_id' => $request->subject[$index] ?? null,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully!'
        ]);
    }

    // Show edit form
    public function edit(Teacher $teacher)
    {
        $commissions = ExaminationCommission::all();

        // Initialize arrays for categories, subcategories, subjects, chapters keyed by mapping index
        $categories = [];
        $subcategories = [];
        $subjects = [];
        $chapters = [];

        // Load teacher exam mappings
        $examMappings = $teacher->examMappings()->with(['category', 'subCategory', 'subject'])->get();

        // For each mapping, prepare related data for dependent selects
        foreach ($examMappings as $index => $mapping) {
            if ($mapping->examType) {
                $categories[$index] = Category::where('exam_com_id', $mapping->examType->id)->get();
            } else {
                $categories[$index] = collect();
            }
            if ($mapping->category) {
                $subcategories[$index] = SubCategory::where('category_id', $mapping->category->id)->get();
            } else {
                $subcategories[$index] = collect();
            }
            if ($mapping->subCategory) {
                $subjects[$index] = Subject::where('sub_category_id', $mapping->subCategory->id)->get();
            } else {
                $subjects[$index] = collect();
            }

        }

        return view('admin.teachers.edit', compact(
            'teacher',
            'commissions',
            'categories',
            'subcategories',
            'subjects',
            'examMappings'
        ));
    }


    public function update(Request $request, Teacher $teacher)
    {
        /* ===============================
         |  VALIDATION
         =============================== */
        $validator = Validator::make($request->all(), [

            /* -------- Personal Info -------- */
            'full_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:teachers,email,' . $teacher->id,
            'mobile_number' => 'required|digits:10',
            'whatsapp_number' => 'nullable|digits:10',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
            'highest_qualification' => 'nullable|string|max:255',
            'total_experience' => 'nullable|numeric|min:0|max:60',

            /* -------- Address -------- */
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'pin_code' => 'nullable|digits_between:4,10',

            /* -------- Language -------- */
            'language' => 'nullable|array',
            'language.*' => 'in:1,2',

            /* -------- Permissions -------- */
            'can_conduct_live_classes' => 'nullable|boolean',
            'can_check_tests' => 'nullable|boolean',

            /* -------- Question Type -------- */
            'question_type_permission' => 'nullable|array',
            'question_type_permission.*' => 'in:MCQ,Subjective,Story / Passage-Based',

            'pay_per_question' => 'nullable|array',
            'pay_per_question.MCQ' => 'nullable|numeric|min:0',
            'pay_per_question.Subjective' => 'nullable|numeric|min:0',
            'pay_per_question.Story / Passage-Based' => 'nullable|numeric|min:0',

            /* -------- Account Setup -------- */
            'exam_type' => 'required|array|min:1',
            'exam_type.*' => 'required|exists:exam_commissions,id',

            'category' => 'nullable|array',
            'category.*' => 'nullable|exists:exam_categories,id',

            'sub_category' => 'nullable|array',
            'sub_category.*' => 'nullable|exists:exam_sub_categories,id',

            'subject' => 'nullable|array',
            'subject.*' => 'nullable|exists:subjects,id',

            /* -------- Bank -------- */
            'upi_id' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:30',
            'confirm_account_number' => 'nullable|same:account_number',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'swift_code' => 'nullable|string|max:20',

            /* -------- Files -------- */
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'pan_file' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'aadhar_front' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'aadhar_back' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'cancelled_cheque' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'qr_code' => 'nullable|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'education_docs' => 'nullable|array',
            'education_docs.*' => 'mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',

            'pan_number' => 'nullable|string|max:20',
            'aadhar_number' => 'nullable|digits:12',
        ]);

        /* ===============================
         |  CONDITIONAL VALIDATION
         =============================== */
        $validator->after(function ($validator) use ($request) {

            $permissions = $request->question_type_permission ?? [];

            if (
                in_array('MCQ', $permissions) &&
                empty($request->pay_per_question['MCQ'])
            ) {
                $validator->errors()->add('pay_per_question.MCQ', 'Pay per MCQ is required.');
            }

            if (
                in_array('Subjective', $permissions) &&
                empty($request->pay_per_question['Subjective'])
            ) {
                $validator->errors()->add('pay_per_question.Subjective', 'Pay per Subjective is required.');
            }

            if (
                in_array('Story / Passage-Based', $permissions) &&
                empty($request->pay_per_question['Story / Passage-Based'])
            ) {
                $validator->errors()->add('pay_per_question.Story / Passage-Based', 'Pay per Story is required.');
            }

            if (!$request->subject || collect($request->subject)->filter()->isEmpty()) {
                $validator->errors()->add('subject', 'At least one subject must be selected.');
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        /* ===============================
         |  UPDATE DATA (TRANSACTION)
         =============================== */
        DB::transaction(function () use ($request, $teacher) {

            /* -------- Personal -------- */
            $teacher->full_name = $request->full_name;
            $teacher->email = $request->email;
            $teacher->mobile_number = $request->mobile_number;
            $teacher->whatsapp_number = $request->whatsapp_number;
            $teacher->gender = $request->gender;
            $teacher->dob = $request->dob;
            $teacher->highest_qualification = $request->highest_qualification;
            $teacher->total_experience = $request->total_experience;
            $teacher->full_address = $request->address;
            $teacher->country = $request->country;
            $teacher->state = $request->state;
            $teacher->city = $request->city;
            $teacher->pin_code = $request->pin_code;

            $teacher->allow_languages = $request->language ?? [];
            $teacher->can_conduct_live_classes = $request->has('can_conduct_live_classes');
            $teacher->can_check_tests = $request->has('can_check_tests');

            /* -------- Question Permissions -------- */
            $permissions = $request->question_type_permission ?? [];
            $payments = $request->pay_per_question ?? [];

            $teacher->allow_mcq = in_array('MCQ', $permissions);
            $teacher->allow_subjective = in_array('Subjective', $permissions);
            $teacher->allow_story = in_array('Story / Passage-Based', $permissions);

            $teacher->pay_per_mcq = $payments['MCQ'] ?? 0;
            $teacher->pay_per_subjective = $payments['Subjective'] ?? 0;
            $teacher->pay_per_story = $payments['Story / Passage-Based'] ?? 0;

            /* -------- Bank -------- */
            $teacher->upi_id = $request->upi_id;
            $teacher->account_name = $request->account_name;
            $teacher->account_number = $request->account_number;
            $teacher->bank_name = $request->bank_name;
            $teacher->bank_branch = $request->bank_branch;
            $teacher->ifsc_code = $request->ifsc_code;
            $teacher->swift_code = $request->swift_code;
            $teacher->pan_number = $request->pan_number;
            $teacher->aadhar_number = $request->aadhar_number;

            /* -------- Files -------- */
            $fileFields = [
                'profile_picture' => 'teachers/profile_pictures',
                'cv' => 'teachers/cv',
                'pan_file' => 'teachers/pan',
                'aadhar_front' => 'teachers/aadhar',
                'aadhar_back' => 'teachers/aadhar',
                'cancelled_cheque' => 'teachers/bank',
                'qr_code' => 'teachers/bank',
            ];

            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    if ($teacher->$field && Storage::disk('public')->exists($teacher->$field)) {
                        Storage::disk('public')->delete($teacher->$field);
                    }
                    $teacher->$field = $request->file($field)->store($path, 'public');
                }
            }

            if ($request->hasFile('education_docs')) {
                if ($teacher->education_docs) {
                    foreach (json_decode($teacher->education_docs, true) ?? [] as $oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }

                $docs = [];
                foreach ($request->file('education_docs') as $file) {
                    $docs[] = $file->store('teachers/education_docs', 'public');
                }
                $teacher->education_docs = json_encode($docs);
            }

            $teacher->save();

            /* -------- Exam Mapping Sync -------- */
            $teacher->examMappings()->delete();

            foreach ($request->exam_type as $index => $examTypeId) {
                TeacherExamMapping::create([
                    'teacher_id' => $teacher->id,
                    'exam_type_id' => $examTypeId,
                    'category_id' => $request->category[$index] ?? null,
                    'sub_category_id' => $request->sub_category[$index] ?? null,
                    'subject_id' => $request->subject[$index] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('manage-teachers.index')
            ->with('success', 'Teacher updated successfully!');
    }


    public function changePassword(Request $request, Teacher $teacher)
    // Validate password and confirmation
    {

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Hash and update password
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        // Redirect back with success message
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);

    }


    // Delete Single Teacher (usually mapped to DELETE /teachers/{teacher})
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            return redirect()->route('manage-teachers.index')->with('success', 'Teacher deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('manage-teachers.index')->with('error', 'Error deleting teacher: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'message' => 'No teachers selected for deletion.'
            ], 400);
        }

        // Optional: Prevent deletion of certain admins or important users
        // $ids = array_filter($ids, fn($id) => $id != 1);

        try {
            Teacher::whereIn('id', $ids)->delete();

            return response()->json([
                'message' => 'Selected teachers deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting teachers: ' . $e->getMessage()
            ], 500);
        }
    }

}
