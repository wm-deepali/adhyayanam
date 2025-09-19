<?php

namespace App\Http\Controllers;

use App\Models\CourseTopic;
use App\Models\ExaminationCommission;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['topics'] = CourseTopic::all();
        return view('content-management.course-topic',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['commissions'] = ExaminationCommission::all();
        $data['subjects'] = Subject::all();
        $data['chapter'] = Chapter::all();
        return view('content-management.course-topic-add',$data);
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
        $data['topic'] = CourseTopic::where('id',$id)->first();
        return view('content-management.course-topic-edit',$data);
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

        CourseTopic::where('id',$id)->update([
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
    { $exam = CourseTopic::findOrFail($id);
        $exam->delete();
        return redirect()->back()->with('success','Topic deleted successfully.');//
    }
}
