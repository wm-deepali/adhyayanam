<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Subject;
use Validator;
use DateTime;
use Storage;
class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
       $datas = Video::where('type','video')->latest()->get();
      
        return view('video.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [];
        $courses = [];
        $chapters = [];
        $teachers = [];
         return view('video.create',compact('categories','courses','chapters','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $request->replace($requestData);
        $rules = [
            'type' => 'required',
            'course_type' => 'required',
            'course_type' => 'required',
            'course_category' => 'required',
            'course' => 'required',
            'chapter' => 'required',
            'title' => 'required',
            'assignment' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'assignment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'slug' => 'required|string|unique:topics,slug', 
        ];
        if ($request->type == "video") {
            $rules['video_type'] = 'required';
            $rules['video_url'] = 'required';
        }
        
        if ($request->type == "live_class") {
            $rules['schedule_date'] = 'required|date|after_or_equal:today';
            $rules['start_time'] = 'required';
            $rules['end_time'] = 'required';
            $rules['teacher'] = 'required';
        }
        
         $validator = Validator::make($requestData, $rules);
            if($validator->fails()){
                     return response()->json([
                        'success'=>false,
                        'code' => 422,
                        'errors'=>$validator->errors(),
                    ]);
                }
                $starttime = DateTime::createFromFormat('g:ia', $request->start_time);
        $endtime = DateTime::createFromFormat('g:ia', $request->end_time);
        if($request->type == "live_class" && (date('Y-m-d') == $request->schedule_date) && (strtotime($request->start_time) < strtotime(date('H:i:s')))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["start_time"=>['Start time must be graeter then or equal to now']],
            ]); 
                }
                
                if($request->type == "live_class" && (strtotime($request->end_time) < strtotime($request->start_time))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["end_time"=>['End time Must be graeter then start time']],
            ]);  
                }
                if($request->type == "live_class" && (strtotime($request->end_time) == strtotime($request->start_time))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["end_time"=>['End time not be same of start time']],
            ]);  
                }
        // Handle image upload
        if ($request->hasFile('image')) {
            $requestData['image'] = $request->image->store('topic','public');
        }
        if ($request->hasFile('cover_image')) {
            $requestData['cover_image'] = $request->cover_image->store('topic','public');
        }
        if($request->hasFile('video_file')){
            $file = $request->file('file');

        // Define a file path and name
        $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();

        // Store the file on S3
        $path = Storage::disk('s3')->put($filePath, file_get_contents($file));

        // Get the URL of the uploaded file
        $url = Storage::disk('s3')->url($filePath);
        $requestData['video_url'] = $url;
        }
        if ($request->hasFile('assignment')) {
            $requestData['assignment'] = $request->assignment->store('topic','public');
        }
        $requestData['teacher_id'] = $request->teacher;
        $requestData['course_id'] = $request->course;
        $requestData['chapter_id'] = $request->chapter;
        if($request->type == "live_class"){
            $requestData['start_time'] = $starttime;
        $requestData['end_time'] = $endtime;
        }
        

        Video::create($requestData);

         return response()->json([
                'success' => true,
                'message' => 'Added Successfully'
            ]);
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
    public function edit(Video $video)
    {
         $chapters = Subject::where('sub_category_id',$video->course_id ??"")->get(['id','name']);
        $categories = Category::where('exam_com_id',$video->course_type?? "")->get(['id','name']);
        $courses = Course::where('category_id',$video->course_category ?? "")->get(['id','name']);
         $teachers = [];
         $topic = $video;
        return view('video.edit', compact('topic','chapters','categories','courses','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $requestData = $request->all();
        $request->replace($requestData);
        $rules = [
            'type' => 'required',
            'course_type' => 'required',
            'course_type' => 'required',
            'course_category' => 'required',
            'course' => 'required',
            'chapter' => 'required',
            'title' => 'required',
            'assignment' => 'required',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'assignment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'slug' => 'required|string|unique:videos,slug,'.$video->id, 
        ];
        if ($request->type == "video") {
            $rules['video_type'] = 'required';
            $rules['video_url'] = 'required';
        }
        
        if ($request->type == "live_class") {
            $rules['schedule_date'] = 'required|date|after_or_equal:today';
            $rules['start_time'] = 'required';
            $rules['end_time'] = 'required';
            $rules['teacher'] = 'required';
        }
        
         $validator = Validator::make($requestData, $rules);
            if($validator->fails()){
                     return response()->json([
                        'success'=>false,
                        'code' => 422,
                        'errors'=>$validator->errors(),
                    ]);
                }
                $starttime = DateTime::createFromFormat('g:ia', $request->start_time);
        $endtime = DateTime::createFromFormat('g:ia', $request->end_time);
        if($request->type == "live_class" && (date('Y-m-d') == $request->schedule_date) && (strtotime($request->start_time) < strtotime(date('H:i:s')))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["start_time"=>['Start time must be graeter then or equal to now']],
            ]); 
                }
                
                if($request->type == "live_class" && (strtotime($request->end_time) < strtotime($request->start_time))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["end_time"=>['End time Must be graeter then start time']],
            ]);  
                }
                if($request->type == "live_class" && (strtotime($request->end_time) == strtotime($request->start_time))){
                   return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>["end_time"=>['End time not be same of start time']],
            ]);  
                }
        // Handle image upload
        if ($request->hasFile('image')) {
            $requestData['image'] = $request->image->store('topic','public');
            if($video->image && Storage::exists($video->image)){
            Storage::delete($video->image);
        }
        
        }else{
            $requestData['image'] = $video->image;
        }
        
        if ($request->hasFile('cover_image')) {
            $requestData['cover_image'] = $request->cover_image->store('topic','public');
            if($video->cover_image && Storage::exists($video->cover_image)){
            Storage::delete($video->cover_image);
        }
        
        }else{
            $requestData['cover_image'] = $video->cover_image;
        }
        
        if ($request->hasFile('assignment')) {
            $requestData['assignment'] = $request->assignment->store('topic','public');
            if($video->assignment && Storage::exists($video->assignment)){
            Storage::delete($video->assignment);
        }
        }else{
            $requestData['assignment'] = $video->assignment;
        }
        if($request->hasFile('video_file')){
            $file = $request->file('file');

        // Define a file path and name
        $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();

        // Store the file on S3
        $path = Storage::disk('s3')->put($filePath, file_get_contents($file));

        // Get the URL of the uploaded file
        $url = Storage::disk('s3')->url($filePath);
        $requestData['video_url'] = $url;
        }
        $requestData['teacher_id'] = $request->teacher;
        $requestData['course_id'] = $request->course;
        $requestData['chapter_id'] = $request->chapter;
       // if($request->type == "live_class"){
        $requestData['start_time'] = date('H:i:s',strtotime($request->start_time));
        $requestData['end_time'] = date('H:i:s',strtotime($request->end_time));
       // }
        

        $video->update($requestData);

         return response()->json([
                'success' => true,
                'message' => 'Added Successfully'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        if($topic->image && Storage::exists($topic->image)){
            Storage::delete($topic->image);
        }
        if($topic->assignment && Storage::exists($topic->assignment)){
            Storage::delete($topic->assignment);
        }
       $topic->delete();
        return redirect()->route('topic.index')->with('success', 'Topic deleted successfully.');
    }
    public function chapter_topic($id)
    {
       $datas = Video::where('chapter_id',$id)->latest()->get();
        return view('video.index', compact('datas'));
    }
    public function course_topic($id)
    {
       $datas = Video::where('course_id',$id)->latest()->get();
        return view('video.index', compact('datas'));
    }
    public function live_class_schedule()
    {
       $datas = Video::where('type','live_class')->latest()->get();
        return view('video.live_class_schedule', compact('datas'));
    }
    
    public function fetchcategory($type)
    {
        try{
            $datas=Category::where('exam_com_id',$type)->get(['id','name']);
            return response()->json([
                "success"=>true,
                "html" => view('admin.ajax.options')->with('datas',$datas)->render(),
            ]);
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $ex){
            return response()->json([
                "success"=>false,
                'msgText' => 'Data Not found by id#' . $id,
            ]);
        }
        catch(\Exception $ex){
            return response()->json([
                "success"=>false,
                'msgText' =>$ex->getMessage(),
            ]);
        }
    }
    public function fetchcourse($id)
    {
        try{
            $datas=Course::where('category_id',$id)->get(['id','name']);
            return response()->json([
                "success"=>true,
                "html" => view('admin.ajax.options')->with('datas',$datas)->render(),
            ]);
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $ex){
            return response()->json([
                "success"=>false,
                'msgText' => 'Data Not found by id#' . $id,
            ]);
        }
        catch(\Exception $ex){
            return response()->json([
                "success"=>false,
                'msgText' =>$ex->getMessage(),
            ]);
        }
    }
    public function fetchchapter($id)
    {
        try{
            $datas=Subject::where('sub_category_id',$id)->get(['id','name']);
            return response()->json([
                "success"=>true,
                "html" => view('admin.ajax.options')->with('datas',$datas)->render(),
            ]);
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $ex){
            return response()->json([
                "success"=>false,
                'msgText' => 'Data Not found by id#' . $id,
            ]);
        }
        catch(\Exception $ex){
            return response()->json([
                "success"=>false,
                'msgText' =>$ex->getMessage(),
            ]);
        }
    }
    public function fetchteacher(Request $request)
    {
        try{
            $datas=Teacher::whereNotIn('teacher_id',[5])->where('for_live_class','yes')->get(['teacher_id  as id','teacherName as name']);
            return response()->json([
                "success"=>true,
                "html" => view('admin.ajax.options')->with('datas',$datas)->render(),
            ]);
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $ex){
            return response()->json([
                "success"=>false,
                'msgText' => 'Data Not found by id#' . $id,
            ]);
        }
        catch(\Exception $ex){
            return response()->json([
                "success"=>false,
                'msgText' =>$ex->getMessage(),
            ]);
        }
    }
}
