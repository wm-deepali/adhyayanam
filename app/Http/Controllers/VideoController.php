<?php

namespace App\Http\Controllers;

use App\Models\CourseTopic;
use App\Models\SubCategory;
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
    public function index(Request $request)
    {
        $search = $request->input('search');
        // VIDEOS
        $videosQuery = Video::where('type', 'video')
            ->with(['examinationCommission', 'category', 'subCategory', 'subject', 'chapter']);

        if ($search) {
            $videosQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('examinationCommission', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('subCategory', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('subject', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        $videos = $videosQuery->latest()->get();

        // LIVE CLASSES
        $liveQuery = Video::where('type', 'live_class')
            ->with(['examinationCommission', 'category', 'subCategory', 'subject', 'teacher']);

        if ($search) {
            $liveQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('examinationCommission', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('subCategory', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('subject', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        $liveClasses = $liveQuery->latest()->get();

        return view('video.index', compact('videos', 'liveClasses'));
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
        return view('video.create', compact('categories', 'courses', 'chapters', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $requestData = $request->all();

        // ✅ Basic validation (common fields)
        $rules = [
            'type' => 'required|in:video,live_class',
            'course_type' => 'required',
            'course_category' => 'required',
            'sub_category_id' => 'required',
            'subject_id' => 'required',
            'topic_id' => 'required',
        ];

        // ✅ Conditional validation
        if ($request->type === 'video') {
            $rules['access_till'] = 'nullable|date';
            $rules['no_of_times_can_view'] = 'nullable|numeric|min:1';
        }

        if ($request->type === 'live_class') {
            $rules['schedule_date'] = 'required|array';
            $rules['schedule_date.*'] = 'required|date|after_or_equal:today';
            $rules['start_time'] = 'required|array';
            $rules['start_time.*'] = 'required';
            $rules['end_time'] = 'required|array';
            $rules['end_time.*'] = 'required';
            $rules['teacher_id'] = 'required|array';
            $rules['teacher_id.*'] = 'required';
        }

        // ✅ Validate base fields
        $validator = Validator::make($requestData, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        // ✅ For VIDEO type
        if ($request->type === 'video') {
            $videoCount = count($request->video_title ?? []);
            for ($i = 0; $i < $videoCount; $i++) {
                $videoData = [
                    'type' => 'video',
                    'course_type' => $request->course_type,
                    'course_category' => $request->course_category,
                    'course_id' => $request->course,
                    'chapter_id' => $request->chapter_id,
                    'sub_category_id' => $request->sub_category_id,
                    'subject_id' => $request->subject_id,
                    'topic_id' => $request->topic_id,
                    'title' => $request->video_title[$i] ?? null,
                    'slug' => $request->video_slug[$i] ?? null,
                    'access_till' => $request->access_till,
                    'no_of_times_can_view' => $request->no_of_times_can_view,
                    'status' => $request->video_status[$i] ?? 'active',
                    'content' => $request->video_content[$i] ?? null,
                    'video_type' => $request->video_type[$i] ?? null,
                    'video_url' => $request->video_url[$i] ?? null,
                    'duration' => $request->duration[$i] ?? null,

                ];

                // ✅ Handle image uploads
                if ($request->hasFile("video_image.$i")) {
                    $videoData['image'] = $request->file("video_image.$i")->store('topic', 'public');
                }
                if ($request->hasFile("video_cover_image.$i")) {
                    $videoData['cover_image'] = $request->file("video_cover_image.$i")->store('topic', 'public');
                }
                if ($request->hasFile("video_assignment.$i")) {
                    $videoData['assignment'] = $request->file("video_assignment.$i")->store('topic', 'public');
                }
                if ($request->hasFile("video_file.$i")) {
                    $videoData['video_file'] = $request->file("video_file.$i")->store('videos', 'public');
                }

                Video::create($videoData);
            }
        }

        // ✅ For LIVE CLASS type
        if ($request->type === 'live_class') {
            $liveCount = count($request->live_title ?? []);
            for ($i = 0; $i < $liveCount; $i++) {
                $liveData = [
                    'type' => 'live_class',
                    'course_type' => $request->course_type,
                    'course_category' => $request->course_category,
                    'course_id' => $request->course,
                    'chapter_id' => $request->chapter_id,
                    'sub_category_id' => $request->sub_category_id,
                    'subject_id' => $request->subject_id,
                    'topic_id' => $request->topic_id,
                    'title' => $request->live_title[$i] ?? null,
                    'schedule_date' => $request->schedule_date[$i] ?? null,
                    'start_time' => $request->start_time[$i] ?? null,
                    'end_time' => $request->end_time[$i] ?? null,
                    'teacher_id' => $request->teacher_id[$i] ?? null,
                    'status' => $request->live_status[$i] ?? 'active',
                    'content' => $request->live_content[$i] ?? null,
                    'live_link' => $request->live_link[$i] ?? null, // ✅ Add this line
                ];

                // ✅ Handle optional assignment image
                if ($request->hasFile("live_assignment.$i")) {
                    $liveData['assignment'] = $request->file("live_assignment.$i")->store('topic', 'public');
                }

                Video::create($liveData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Videos added successfully.',
        ]);
    }


    public function show(string $id)
    {
        // dd('here');
        // try {
        // Fetch video with relationships
        $video = Video::with([
            'examinationCommission:id,name',
            'category:id,name',
            'subCategory:id,name',
            'course:id,name',
            'subject:id,name',
            'chapter:id,name',
            'topic:id,name',
            'teacher:id,full_name',
        ])->findOrFail($id);

        return view('video.show', compact('video'));

        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     return redirect()->route('video.index')->with('error', 'Video not found.');
        // } catch (\Exception $e) {
        //     return redirect()->route('video.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        // }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        // Fetch categories for the selected Examination Commission
        $categories = Category::where('exam_com_id', $video->course_type ?? null)->get(['id', 'name']);

        // Fetch subcategories for the selected category
        $subCategories = SubCategory::where('category_id', $video->course_category ?? null)->get(['id', 'name']);

        // Fetch courses for the selected subcategory
        $courses = Course::where('sub_category_id', $video->sub_category_id ?? null)->get(['id', 'name']);

        // Fetch subjects for the selected subcategory
        $subjects = Subject::where('sub_category_id', $video->sub_category_id ?? null)->get(['id', 'name']);

        // Fetch chapters for the selected subject
        $chapters = Chapter::where('subject_id', $video->subject_id ?? null)->get(['id', 'name']);

        // Fetch topics for the selected chapter
        $topics = CourseTopic::where('chapter_id', $video->chapter_id ?? null)->get(['id', 'name']);

        /**
         * ✅ Fetch only relevant teachers based on exam type, category, subcategory, and subject
         */
        $teacherIds = \App\Models\TeacherExamMapping::query()
            ->when($video->course_type, fn($q) => $q->where('exam_type_id', $video->course_type))
            ->when($video->course_category, fn($q) => $q->where('category_id', $video->course_category))
            ->when($video->sub_category_id, fn($q) => $q->where('sub_category_id', $video->sub_category_id))
            ->when($video->subject_id, fn($q) => $q->where('subject_id', $video->subject_id))
            ->pluck('teacher_id')
            ->unique();

        $teachers = Teacher::whereIn('id', $teacherIds)->select('id', 'full_name')->get();

        return view('video.edit', compact(
            'video',
            'categories',
            'subCategories',
            'courses',
            'subjects',
            'chapters',
            'topics',
            'teachers'
        ));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        try {
            $requestData = $request->all();

            // ✅ Validation Rules
            $rules = [
                'type' => 'required',
                'course_type' => 'required',
                'course_category' => 'required',
                'sub_category_id' => 'required',
                'course' => 'required',
                'subject_id' => 'required',
                'chapter_id' => 'required',
                'topic_id' => 'required',
                'title' => 'required|string',
                'slug' => 'nullable|string|unique:videos,slug,' . $video->id,
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'assignment' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
            ];

            if ($request->type === "video") {
                $rules['video_type'] = 'required';
                $rules['video_url'] = 'required|string';
            }

            if ($request->type === "live_class") {
                $rules['schedule_date'] = 'required|date|after_or_equal:today';
                $rules['start_time'] = 'required';
                $rules['end_time'] = 'required';
                $rules['teacher'] = 'required';
                $rules['live_link'] = 'nullable|url';
            }

            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'code' => 422,
                    'errors' => $validator->errors(),
                ]);
            }

            // ✅ Time Validation for Live Classes
            if ($request->type === "live_class") {
                $start_time = strtotime($request->start_time);
                $end_time = strtotime($request->end_time);

                if ($request->schedule_date === date('Y-m-d') && $start_time < strtotime(date('H:i:s'))) {
                    return response()->json([
                        'success' => false,
                        'code' => 422,
                        'errors' => ['start_time' => ['Start time must be greater than or equal to current time']],
                    ]);
                }

                if ($end_time <= $start_time) {
                    return response()->json([
                        'success' => false,
                        'code' => 422,
                        'errors' => ['end_time' => ['End time must be greater than start time']],
                    ]);
                }
            }

            // ✅ Handle File Uploads
            // Image
            if ($request->hasFile('image')) {
                if ($video->image && Storage::disk('public')->exists($video->image)) {
                    Storage::disk('public')->delete($video->image);
                }
                $requestData['image'] = $request->file('image')->store('topic', 'public');
            } else {
                $requestData['image'] = $video->image;
            }

            // Cover Image
            if ($request->hasFile('cover_image')) {
                if ($video->cover_image && Storage::disk('public')->exists($video->cover_image)) {
                    Storage::disk('public')->delete($video->cover_image);
                }
                $requestData['cover_image'] = $request->file('cover_image')->store('topic', 'public');
            } else {
                $requestData['cover_image'] = $video->cover_image;
            }

            // Assignment
            if ($request->hasFile('assignment')) {
                if ($video->assignment && Storage::disk('public')->exists($video->assignment)) {
                    Storage::disk('public')->delete($video->assignment);
                }
                $requestData['assignment'] = $request->file('assignment')->store('topic', 'public');
            } else {
                $requestData['assignment'] = $video->assignment;
            }

            // ✅ S3 Video Upload (if applicable)
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $requestData['video_url'] = Storage::disk('s3')->url($filePath);
            }

            // ✅ Map field names to DB fields
            $requestData['teacher_id'] = $request->teacher ?? $video->teacher_id;
            $requestData['course_id'] = $request->course;
            $requestData['chapter_id'] = $request->chapter_id;
            $requestData['sub_category_id'] = $request->sub_category_id;
            $requestData['subject_id'] = $request->subject_id;
            $requestData['topic_id'] = $request->topic_id;

            if ($request->type === "live_class") {
                $requestData['start_time'] = date('H:i:s', strtotime($request->start_time));
                $requestData['end_time'] = date('H:i:s', strtotime($request->end_time));
                $requestData['live_link'] = $request->live_link ?? $video->live_link; // ✅ Add this line
            }

            // ✅ Update Video
            $video->update($requestData);

            return response()->json([
                'success' => true,
                'message' => 'Video updated successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        if ($video->image && Storage::exists($video->image)) {
            Storage::delete($video->image);
        }
        if ($video->cover_image && Storage::exists($video->cover_image)) {
            Storage::delete($video->cover_image);
        }
        if ($video->assignment && Storage::exists($video->assignment)) {
            Storage::delete($video->assignment);
        }
        $video->delete();
        return redirect()->route('video.index')->with('success', 'Video deleted successfully.');
    }

    public function chapter_topic($id)
    {
        $datas = Video::where('chapter_id', $id)->latest()->get();
        return view('video.index', compact('datas'));
    }

    public function course_topic($id)
    {
        $datas = Video::where('course_id', $id)->latest()->get();
        return view('video.index', compact('datas'));
    }

    public function live_class_schedule()
    {
        $datas = Video::where('type', 'live_class')->latest()->get();
        return view('video.live_class_schedule', compact('datas'));
    }

    public function fetchcategory($type)
    {
        try {
            $datas = Category::where('exam_com_id', $type)->get(['id', 'name']);
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.options')->with('datas', $datas)->render(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json([
                "success" => false,
                'msgText' => 'Data Not found by type#' . $type,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }
    public function fetchcourse($id, Request $request)
    {
        try {
            $query = Course::where('sub_category_id', $id);

            // Filter by type if sent
            if ($request->has('type')) {
                if ($request->type == 'video') {
                    $query->where('course_mode', 'video learning');
                } elseif ($request->type == 'live_class') {
                    $query->where('course_mode', 'Online');
                }
            }

            $datas = $query->get(['id', 'name']);

            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.options')->with('datas', $datas)->render(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json([
                "success" => false,
                'msgText' => 'Data Not found by id#' . $id,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function fetchChapter(Request $request, $id)
    {
        try {
            $course = Course::findOrFail($id);

            // Subject options
            if (!empty($course->subject_id)) {
                $subjects = Subject::whereIn('id', $course->subject_id)->get(['id', 'name']);
            } else {
                $subjects = Subject::where('sub_category_id', $course->sub_category_id)->get(['id', 'name']);
            }

            // Chapter options
            if (!empty($course->chapter_id)) {
                $chapters = Chapter::whereIn('id', $course->chapter_id)->get(['id', 'name']);
            } else {
                if ($request->has('subject_id')) {
                    $chapters = Chapter::where('subject_id', $request->subject_id)->get(['id', 'name']);
                    $topics = CourseTopic::where('subject_id', $request->subject_id)->get(['id', 'name']);
                } else {
                    $chapters = Chapter::where('sub_category_id', $course->sub_category_id)->get(['id', 'name']);
                }
            }

            // Topic options
            if (!empty($course->topic_id)) {
                $topics = CourseTopic::whereIn('id', $course->topic_id)->get(['id', 'name']);
            } else {
                // If chapter_ids are passed, filter topics by them
                if ($request->has('chapter_id')) {
                    $topics = CourseTopic::where('chapter_id', $request->chapter_id)->get(['id', 'name']);
                } else {
                    $topics = CourseTopic::where('sub_category_id', $course->sub_category_id)->get(['id', 'name']);
                }
            }

            return response()->json([
                "success" => true,
                "subject_html" => view('admin.ajax.options')->with('datas', $subjects)->render(),
                "chapter_html" => view('admin.ajax.options')->with('datas', $chapters)->render(),
                "topic_html" => view('admin.ajax.options')->with('datas', $topics)->render(),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return response()->json([
                "success" => false,
                'msgText' => 'Course not found by id#' . $id,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                'msgText' => $ex->getMessage(),
            ]);
        }
    }

    public function fetchTeachersByFilters(Request $request)
    {
        $query = \App\Models\TeacherExamMapping::query();

        if ($request->exam_type_id) {
            $query->where('exam_type_id', $request->exam_type_id);
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->sub_category_id) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $teacherIds = $query->pluck('teacher_id')->unique();
        $teachers = Teacher::whereIn('id', $teacherIds)->get();

        $html = '<option value="">Select Teacher</option>';
        foreach ($teachers as $teacher) {
            $html .= '<option value="' . $teacher->id . '">' . e($teacher->full_name) . '</option>';
        }

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

}
