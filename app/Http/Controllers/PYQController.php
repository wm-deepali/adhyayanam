<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\PyqSubject;
use App\Models\PYQ;
use App\Models\Category;
use App\Models\ExaminationCommission;
use App\Models\SubCategory;
use App\Models\Subject;

class PYQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['test'] = Test::with('subject', 'topic', 'commission', 'category', 'testDetails')->where('paper_type', 1)->get();

        return view('pyq.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['commissions'] = ExaminationCommission::all();

        return view('pyq.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'commission_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            // 'sub_category_id' => 'required_without:subject_id|exists:sub_category,id',
            // 'subject_id*' => 'required_without:sub_category_id|exists:subject,id',
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:255',
            'status' => 'required',
            'pdf' => "required|mimes:pdf|max:10000",
        ]);

        // Handle image upload
        if ($request->hasFile('pdf')) {
            $getFileExt = $request->file('pdf')->getClientOriginalExtension();
            $year = $request->year;
            $pdf_name = time() . '-' . $year . '.' . $getFileExt;
            $pdfPath = $request->file('pdf')->storeAs('pyq-pdf', $pdf_name);
        } else {
            $pdf_name = null;
        }
        if (!empty($request->subject_id)) {
            $has_subject = 1;
        } else {
            $has_subject = 0;
        }

        if (!empty($request->subject_id) && isset($request->subject_id)) {
            $paper_type = "Subject Based";

        } else if (isset($request->sub_category_id) && $request->sub_category_id != '') {
            $paper_type = "Sub-Cat Based";
        } else {
            $paper_type = "Category Wise";
        }


        $PYQ = new PYQ();
        $PYQ->commission_id = $request->commission_id;
        $PYQ->category_id = $request->category_id;
        $PYQ->sub_cat_id = $request->sub_category_id ?? NULL;
        $PYQ->has_subject = $has_subject;
        $PYQ->title = $request->title;
        $PYQ->year = $request->year;
        $PYQ->paper_type = $paper_type;
        $PYQ->pdf = $pdf_name;
        $PYQ->status = $request->status;

        // Save the ExaminationCommission instance to the database
        $PYQ->save();

        if ($has_subject == 1) {
            PyqSubject::create([
                'pyq_id' => $PYQ->id,
                'subject_id' => $request->subject_id,
            ]);
        }


        return redirect()->route('pyq.index')->with('success', 'PYQ created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pyq = PYQ::findOrFail($id);
        $selectSubjects = PyqSubject::where('pyq_id', $id)->first();
        $selectSub = $selectSubjects;
        $commissions = ExaminationCommission::get();
        $categories = Category::where('exam_com_id', $pyq->commission_id)->get();
        if ($pyq->sub_category_id != NULL) {
            $subcategories = SubCategory::where('category_id', $pyq->category_id)->get();
        } else {
            $subcategories = array();
        }
        $subjects = Subject::where('sub_category_id', $pyq->sub_category_id)->get();

        return view('pyq.edit')->with('pyq', $pyq)->with('commissions', $commissions)->with('categories', $categories)->with('subcategories', $subcategories)->with('subjects', $subjects)->with('selectSub', $selectSub);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'commission_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            // 'sub_category_id' => 'required_without:subject_id|exists:sub_category,id',
            // 'subject_id*' => 'required_without:sub_category_id|exists:subject,id',
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:255',
            'status' => 'required',
            'pdf' => "nullable|mimes:pdf|max:10000",
        ]);

        $pyq = PYQ::findOrFail($id);
        // Handle image upload
        if ($request->hasFile('pdf')) {
            $getFileExt = $request->file('pdf')->getClientOriginalExtension();
            $year = $request->year;
            $pdf_name = time() . '-' . $year . '.' . $getFileExt;
            $pdfPath = $request->file('pdf')->storeAs('pyq-pdf', $pdf_name);
        } else {
            $pdf_name = $pyq->pdf;
        }
        if (!empty($request->subject_id)) {
            $has_subject = 1;
        } else {
            $has_subject = 0;
        }

        if (!empty($request->subject_id) && isset($request->subject_id)) {
            $paper_type = "Subject Based";

        } else if (isset($request->sub_category_id) && $request->sub_category_id != '') {
            $paper_type = "Sub-Cat Based";
        } else {
            $paper_type = "Category Wise";
        }

        $testData = array(
            'commission_id' => $request->commission_id,
            'category_id' => $request->category_id,
            'sub_cat_id' => $request->sub_category_id ?? NULL,
            'has_subject' => $has_subject,
            'title' => $request->title,
            'year' => $request->year,
            'paper_type' => $paper_type,
            'pdf' => $pdf_name,
            'status' => $request->status,
        );
        $pyq->update($testData);


        if ($has_subject == 1) {
            PyqSubject::where('pyq_id', $pyq->id)->delete();
            PyqSubject::create([
                'pyq_id' => $pyq->id,
                'subject_id' => $request->subject_id,
            ]);
        }


        return redirect()->route('pyq.index')->with('success', 'PYQ updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pyq = PYQ::findOrFail($id);
        PyqSubject::where('pyq_id', $pyq->id)->delete();
        $pyq->delete();
        return redirect()->route('pyq.index')->with('success', 'PYQ deleted successfully!');
    }

    function check($array, $key)
    {
        if (array_key_exists($key, $array)) {
            if (is_null($array[$key])) {
                return 0;
            } else {
                return 1;
            }
        }
    }
}
