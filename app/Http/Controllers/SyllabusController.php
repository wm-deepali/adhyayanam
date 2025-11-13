<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\ExaminationCommission;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $syllabusList = Syllabus::with(['commission', 'category', 'subCategory', 'subject'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('syllabus.index', compact('syllabusList'));
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
