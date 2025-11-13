<?php

namespace App\Http\Controllers;

use App\Models\CourseTopic;
use App\Models\ExaminationCommission;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CourseTopic::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('subject', function ($row) {
                    return $row->subject->name ?? '';
                })

                ->addColumn('chapter', function ($row) {
                    return $row->chapter->name ?? '';
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.chapter.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('cm.chapter.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'subject', 'status', 'action'])
                ->make(true);
        }
        return view('content-management.course-topic');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['commissions'] = ExaminationCommission::all();
        $data['subjects'] = Subject::all();
        $data['chapter'] = Chapter::all();
        return view('content-management.course-topic-add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'exam_com_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'required|exists:subject,id',
            'chapter_id' => 'required|exists:chapter,id',
            'name' => 'required|string|max:255',
            'chapter_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        CourseTopic::create([
            'exam_com_id' => $request->exam_com_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id ?? NULL,
            'subject_id' => $request->subject_id,
            'chapter_id' => $request->chapter_id,
            'name' => $request->name,
            'topic_number' => $request->topic_number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('topic.index')->with('success', 'Topic created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseTopic $courseTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['commissions'] = ExaminationCommission::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = Category::all();
        $data['subjects'] = Subject::all();
        $data['chapters'] = Chapter::all();
        $data['topic'] = CourseTopic::where('id', $id)->first();
        return view('content-management.course-topic-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'exam_com_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'required|exists:subject,id',
            'chapter_id' => 'required|exists:chapter,id',
            'name' => 'required|string|max:255',
            'chapter_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        CourseTopic::where('id', $id)->update([
            'exam_com_id' => $request->exam_com_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id ?? NULL,
            'subject_id' => $request->subject_id,
            'chapter_id' => $request->chapter_id,
            'name' => $request->name,
            'topic_number' => $request->topic_number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('topic.index')->with('success', 'Topic updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $exam = CourseTopic::findOrFail($id);
        $exam->delete();
        return redirect()->back()->with('success', 'Topic deleted successfully.');//
    }
}
