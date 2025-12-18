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
        // dd($request->all());
        $request->validate([
            // 🔹 Personal Info
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'mobile_number' => 'required|string|max:15',
            'confirm_account_number' => 'same:account_number',
            'password' => 'required|string|min:6|confirmed',

            // 🔹 Images
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar_front' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'aadhar_back' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'pan_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'cancelled_cheque' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'qr_code' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',

            // 🔹 Docs
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'education_docs.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
        ]);


        // try {
        $teacher = new Teacher();

        // Personal
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
        $teacher->can_conduct_live_classes = $request->has('can_conduct_live_classes') ? 1 : 0;
        $teacher->can_check_tests = $request->has('can_check_tests') ? 1 : 0;
        $teacher->allow_languages = $request->language ?? [];

        // Store hashed password
        $teacher->password = Hash::make($request->password);

        // Question Type Permission
        $permissions = $request->question_type_permission ?? [];
        $payments = $request->pay_per_question ?? [];

        $teacher->allow_mcq = in_array('MCQ', $permissions);
        $teacher->allow_subjective = in_array('Subjective', $permissions);
        $teacher->allow_story = in_array('Story / Passage-Based', $permissions);

        $teacher->pay_per_mcq = $payments['MCQ'] ?? 0;
        $teacher->pay_per_subjective = $payments['Subjective'] ?? 0;
        $teacher->pay_per_story = $payments['Story / Passage-Based'] ?? 0;

        // Bank Details
        $teacher->upi_id = $request->upi_id;
        $teacher->account_name = $request->account_name;
        $teacher->account_number = $request->account_number;
        $teacher->bank_name = $request->bank_name;
        $teacher->bank_branch = $request->bank_branch;
        $teacher->ifsc_code = $request->ifsc_code;
        $teacher->swift_code = $request->swift_code;
        $teacher->created_by = auth()->id();

        // Files
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
            $paths = [];
            foreach ($request->file('education_docs') as $file) {
                $paths[] = $file->store('teachers/education_docs', 'public');
            }
            $teacher->education_docs = json_encode($paths);
        }

        $teacher->save();
        // 🔹 Save Teacher Exam Mappings
        if ($request->exam_type) {
            foreach ($request->exam_type as $index => $examTypeId) {
                // Skip if exam_type is empty
                if (!$examTypeId)
                    continue;

                TeacherExamMapping::create([
                    'teacher_id' => $teacher->id,
                    'exam_type_id' => $examTypeId,
                    'category_id' => $request->category[$index] ?? null,
                    'sub_category_id' => $request->sub_category[$index] ?? null,
                    'subject_id' => $request->subject[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('manage-teachers.index')->with('success', 'Teacher created successfully!');

        // } catch (\Exception $e) {
        //     return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        // }
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


    // Update teacher data

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            // 🔹 Personal Info
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'mobile_number' => 'required|string|max:15',
            'confirm_account_number' => 'same:account_number',

            // 🔹 Images
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar_front' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'aadhar_back' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'pan_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'cancelled_cheque' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
            'qr_code' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',

            // 🔹 Docs
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'education_docs.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
        ]);

        // Update basic info
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
        $teacher->can_conduct_live_classes = $request->has('can_conduct_live_classes') ? 1 : 0;
        $teacher->can_check_tests = $request->has('can_check_tests') ? 1 : 0;

        // Update Question Permissions and Payment
        $permissions = $request->question_type_permission ?? [];
        $payments = $request->pay_per_question ?? [];

        $teacher->allow_mcq = in_array('MCQ', $permissions);
        $teacher->allow_subjective = in_array('Subjective', $permissions);
        $teacher->allow_story = in_array('Story / Passage-Based', $permissions);

        $teacher->pay_per_mcq = $payments['MCQ'] ?? 0;
        $teacher->pay_per_subjective = $payments['Subjective'] ?? 0;
        $teacher->pay_per_story = $payments['Story / Passage-Based'] ?? 0;

        // Bank details
        $teacher->upi_id = $request->upi_id;
        $teacher->account_name = $request->account_name;
        $teacher->account_number = $request->account_number;
        $teacher->bank_name = $request->bank_name;
        $teacher->bank_branch = $request->bank_branch;
        $teacher->ifsc_code = $request->ifsc_code;
        $teacher->swift_code = $request->swift_code;

        // Handling file uploads and deleting old files if updated
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
                // Delete old file if exists
                if ($teacher->$field && Storage::disk('public')->exists($teacher->$field)) {
                    Storage::disk('public')->delete($teacher->$field);
                }

                // Store new file
                $teacher->$field = $request->file($field)->store($path, 'public');
            }
        }

        // Handling multiple education documents (delete old and save new)
        if ($request->hasFile('education_docs')) {
            // Delete old education docs
            if ($teacher->education_docs) {
                $oldDocs = json_decode($teacher->education_docs, true);
                if (is_array($oldDocs)) {
                    foreach ($oldDocs as $oldFile) {
                        if (Storage::disk('public')->exists($oldFile)) {
                            Storage::disk('public')->delete($oldFile);
                        }
                    }
                }
            }

            // Store new education documents
            $paths = [];
            foreach ($request->file('education_docs') as $file) {
                $paths[] = $file->store('teachers/education_docs', 'public');
            }
            $teacher->education_docs = json_encode($paths);
        }

        $teacher->save();

        // Update Teacher Exam Mappings
        if ($request->exam_type) {
            // Prepare incoming mappings from request
            $inputMappings = $request->input('exam_type', []);
            $inputCategories = $request->input('category', []);
            $inputSubCategories = $request->input('sub_category', []);
            $inputSubjects = $request->input('subject', []);

            // To keep track mappings for update, create and delete
            $receivedMappingIds = [];

            foreach ($inputMappings as $index => $examTypeId) {
                if (!$examTypeId)
                    continue; // skip empty

                // Search existing mapping with same exam_type_id and possibly other keys
                $existing = $teacher->examMappings()
                    ->where('exam_type_id', $examTypeId)
                    ->where('category_id', $inputCategories[$index] ?? null)
                    ->where('sub_category_id', $inputSubCategories[$index] ?? null)
                    ->where('subject_id', $inputSubjects[$index] ?? null)
                    ->first();

                if ($existing) {
                    // Already exists, so no need to create, just track its id
                    $receivedMappingIds[] = $existing->id;
                } else {
                    // Create new mapping
                    $mapping = new TeacherExamMapping();
                    $mapping->teacher_id = $teacher->id;
                    $mapping->exam_type_id = $examTypeId;
                    $mapping->category_id = $inputCategories[$index] ?? null;
                    $mapping->sub_category_id = $inputSubCategories[$index] ?? null;
                    $mapping->subject_id = $inputSubjects[$index] ?? null;
                    $mapping->save();

                    $receivedMappingIds[] = $mapping->id;
                }
            }

            // Delete mappings that exist in DB but not in the current request
            $teacher->examMappings()
                ->whereNotIn('id', $receivedMappingIds)
                ->delete();
        }

        return redirect()->route('manage-teachers.index')->with('success', 'Teacher updated successfully!');
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
