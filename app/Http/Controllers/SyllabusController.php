<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\ExaminationCommission;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        // 🔹 AJAX request → DataTable JSON
        if ($request->ajax()) {

            $query = Syllabus::with([
                'commission',
                'category',
                'subCategory',
                'subject',
                'creator'
            ])->orderBy('created_at', 'DESC');

            return DataTables::of($query)
                ->addIndexColumn() // # column

                // Date & Time
                ->editColumn('created_at', function ($res) {
                    return $res->created_at
                        ? $res->created_at->format('d M Y, h:i A')
                        : '-';
                })

                // ✅ TYPE (this was missing earlier)
                ->addColumn('type', function ($res) {
                    return $res->type ?? '-';
                })

                // Subject
                ->addColumn('subject', function ($res) {
                    return $res->subject->name ?? '_';
                })

                // Exam Commission
                ->addColumn('commission', function ($res) {
                    return $res->commission->name ?? '_';
                })

                // Category
                ->addColumn('category', function ($res) {
                    return $res->category->name ?? '_';
                })

                // Sub Category
                ->addColumn('subcategory', function ($res) {
                    return $res->subCategory->name ?? '_';
                })

                // PDF
                ->addColumn('pdf', function ($res) {
                    if ($res->pdf) {
                        return '<a href="' . asset('storage/' . $res->pdf) . '" target="_blank">
                                <img height="40" src="' . asset('img/pdficon.png') . '" alt="PDF">
                            </a>';
                    }
                    return '<span class="text-muted">No PDF</span>';
                })

                // Status
                ->addColumn('status', function ($res) {
                    return $res->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                // Added By
                ->addColumn('created_by', function ($res) {
                    return $res->creator ? $res->creator->name : 'N/A';
                })

                // Action (same dropdown you already use)
                ->addColumn('action', function ($res) {

                    $html = '<div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                        type="button" data-bs-toggle="dropdown">
                        Actions
                    </button>
                    <ul class="dropdown-menu">';

                    if (\App\Helpers\Helper::canAccess('manage_syllabus')) {
                        $html .= '<li>
                        <a class="dropdown-item" href="' . route('syllabus.show', $res->id) . '">
                            <i class="fa fa-eye text-primary me-2"></i> View
                        </a>
                    </li>';
                    }

                    if (\App\Helpers\Helper::canAccess('manage_syllabus_edit')) {
                        $html .= '<li>
                        <a class="dropdown-item" href="' . route('syllabus.edit', $res->id) . '">
                            <i class="fa fa-edit text-primary me-2"></i> Edit
                        </a>
                    </li>';
                    }

                    if (\App\Helpers\Helper::canAccess('manage_syllabus_delete')) {
                        $html .= '<li>
                        <form action="' . route('syllabus.destroy', $res->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="dropdown-item text-danger"
                                onclick="return confirm(\'Are you sure?\')">
                                <i class="fa fa-trash me-2"></i> Delete
                            </button>
                        </form>
                    </li>';
                    }

                    $html .= '</ul></div>';

                    return $html;
                })

                ->rawColumns(['pdf', 'status', 'action'])
                ->make(true);
        }

        // 🔹 Normal page load
        return view('syllabus.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $syllabus = Syllabus::with(['commission', 'category', 'subCategory', 'subject'])->findOrFail($id);

        return view('syllabus.show', compact('syllabus'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commissions = ExaminationCommission::all();
        return view('syllabus.create', compact('commissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commission_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'nullable|exists:subject,id',
            'title' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:10240', // 10MB max
            'status' => 'required|boolean',
            'detail_content' => 'nullable|string',
        ]);

        // Handle PDF upload
        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $pdfName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $pdfPath = $request->file('pdf')->storeAs('uploads/syllabus', $pdfName, 'public');
        }

        // Determine type
        if (!empty($request->subject_id)) {
            $type = "Subject Based";
        } elseif (!empty($request->sub_category_id)) {
            $type = "Sub-Cat Based";
        } else {
            $type = "Category Wise";
        }

        Syllabus::create([
            'commission_id' => $request->commission_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'type' => $type,
            'pdf' => $pdfPath,
            'detail_content' => $request->detail_content,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('syllabus.index')
            ->with('success', 'Syllabus created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $syllabus = Syllabus::findOrFail($id);
        $commissions = ExaminationCommission::all();
        $categories = Category::where('exam_com_id', $syllabus->commission_id)->get();
        $subcategories = SubCategory::where('category_id', $syllabus->category_id)->get();
        $subjects = Subject::where('sub_category_id', $syllabus->sub_category_id)->get();

        return view('syllabus.edit', compact('syllabus', 'commissions', 'categories', 'subcategories', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'commission_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'nullable|exists:subject,id',
            'title' => 'required|string|max:255',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'status' => 'required|boolean',
            'detail_content' => 'nullable|string',
        ]);

        $syllabus = Syllabus::findOrFail($id);

        // Handle new PDF upload (and delete old)
        $pdfPath = $syllabus->pdf;
        if ($request->hasFile('pdf')) {
            if ($syllabus->pdf && Storage::disk('public')->exists($syllabus->pdf)) {
                Storage::disk('public')->delete($syllabus->pdf);
            }

            $pdfName = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $pdfPath = $request->file('pdf')->storeAs('uploads/syllabus', $pdfName, 'public');
        }

        // Determine type
        if (!empty($request->subject_id)) {
            $type = "Subject Based";
        } elseif (!empty($request->sub_category_id)) {
            $type = "Sub-Cat Based";
        } else {
            $type = "Category Wise";
        }

        $syllabus->update([
            'commission_id' => $request->commission_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'type' => $type,
            'pdf' => $pdfPath,
            'detail_content' => $request->detail_content,
            'status' => $request->status,
        ]);

        return redirect()->route('syllabus.index')
            ->with('success', 'Syllabus updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $syllabus = Syllabus::findOrFail($id);

        if ($syllabus->pdf && Storage::disk('public')->exists($syllabus->pdf)) {
            Storage::disk('public')->delete($syllabus->pdf);
        }

        $syllabus->delete();

        return redirect()->route('syllabus.index')
            ->with('success', 'Syllabus deleted successfully!');
    }
}
