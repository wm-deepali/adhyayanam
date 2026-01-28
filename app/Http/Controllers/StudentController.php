<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\StudentTestAttempt;
use App\Models\StudyMaterial;
use App\Models\TestSeries;
use App\Models\User;
use App\Models\Order;
use App\Models\VideoUserProgress;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    //
    public function studentProfile($id)
    {
        $data['profile'] = User::where('id', $id)->where('type', 'student')->first();
        $data['course'] = Helper::getStudentCourseData($id);
        $data['testSeries'] = Helper::getStudentTestSeriesData($id);
        $data['studyMaterial'] = Helper::getStudentStudyMaterialData($id);
        return view('students.student-profile-detail', $data);
    }
    public function studentChangePassword($id)
    {
        $data['id'] = $id;
        return view('students.student-change-password', $data);
    }

    public function studentUpdatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|string',
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        \LogActivity::addToLog('Password Update', $user);

        return back()->with('success', "Password Changed Successfully");
    }

    public function studentTestSummery(Request $request)
    {
        $query = User::where('type', 'student')
            ->withCount([
                'testSeriesOrder',
                'testSeriesOrderAttempt',
                'testSeriesOrderPending'
            ]);

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // PAGINATION
        $students = $query->paginate(10)->withQueryString();

        // LAST ORDER CODE
        $students->getCollection()->transform(function ($row) {
            $lastOrder = Helper::getStudentTestSeriesData($row->id);
            $row->last_order = $lastOrder['lastOrderCode'] ?? '--';
            $row->test_series_id = $lastOrder['test_series_id'] ?? null;
            return $row;
        });

        return view('students.student-test-series-summary', compact('students'));
    }

    public function studentCourseSummery(Request $request)
    {
        $query = User::where('type', 'student')
            ->withCount([
                'courseOrder',
                'courseOrderAttempt',
                'courseOrderPending'
            ]);

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // PAGINATION
        $students = $query->paginate(10)->withQueryString();

        // LAST COURSE ORDER
        $students->getCollection()->transform(function ($row) {
            $lastOrder = Helper::getStudentCourseData($row->id);
            $row->last_order = $lastOrder['lastOrderCode'] ?? '--';
            $row->course_id = $lastOrder['course_id'] ?? null;
            return $row;
        });

        return view('students.student-course-summary', compact('students'));
    }

    public function RegisterStudentList(Request $request)
    {
        $query = User::where('type', 'student')
            ->withSum('transactions', 'paid_amount')
            ->withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // ✅ PAGINATION
        $students = $query->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        // keep last order logic
        $students->getCollection()->transform(function ($row) {
            $row->last_order = Helper::getStudentlastOrderID($row->id);
            return $row;
        });

        return view('students.registered-student-list', compact('students'));
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function ViewAllOrder($id)
    {
        $data['orders'] = Order::with('student', 'transaction')->where('student_id', $id)->get();
        return view('students.student-all-orders', $data);
    }

    public function studentTestDetail($studentId, $testSeriesId)
    {
        $student = User::where('id', $studentId)
            ->where('type', 'student')
            ->firstOrFail();

        $testSeries = TestSeries::with([
            'tests.subject',
            'tests.chapter',
            'tests.topic',
            'testseries' // for type_name counts
        ])->findOrFail($testSeriesId);

        $order = Order::where('student_id', $studentId)
            ->where('package_id', $testSeriesId)
            ->where('order_type', 'Test Series')
            ->first();

        $attemptedTestIds = StudentTestAttempt::where('student_id', $studentId)
            ->whereIn('test_id', $testSeries->tests->pluck('id'))
            ->where('status', '!=', 'in_progress')
            ->pluck('test_id')
            ->toArray();

        return view('students.student-test-series-detail', compact(
            'student',
            'testSeries',
            'order',
            'attemptedTestIds'
        ));
    }

    public function studentCourseDetail($studentId, $courseId)
    {
        $student = User::where('id', $studentId)
            ->where('type', 'student')
            ->firstOrFail();

        $course = Course::with([
            'videos.teacher',
            'videos.homeworkSubmissions' => function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            }
        ])->findOrFail($courseId);

        $order = Order::where('student_id', $studentId)
            ->where('package_id', $courseId)
            ->where('order_type', 'Course')
            ->first();

        $totalLessons = $course->videos->count();
        $completedLessons = $course->videos
            ->filter(fn($v) => $v->homeworkSubmissions->isNotEmpty())
            ->count();

        return view('students.student-course-detail', compact(
            'student',
            'course',
            'order',
            'totalLessons',
            'completedLessons'
        ));
    }

    public function videoSummary(Request $request)
    {
        $query = Video::query()
            ->select(
                'videos.id',
                'videos.title',
                'videos.course_id',
                'videos.teacher_id',
                DB::raw('COALESCE(SUM(vup.watched_count),0) as total_views'),
                DB::raw('COUNT(DISTINCT vup.user_id) as total_students')
            )
            ->leftJoin('video_user_progress as vup', 'vup.video_id', '=', 'videos.id')
            ->with(['course:id,course_heading', 'teacher:id,full_name'])
            ->groupBy(
                'videos.id',
                'videos.title',
                'videos.course_id',
                'videos.teacher_id'
            );

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('videos.title', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($c) use ($search) {
                        $c->where('course_heading', 'like', "%{$search}%");
                    });
            });
        }

        $videos = $query->paginate(20)->withQueryString();

        return view('students.student-videos-summary', compact('videos'));
    }

    public function videoDetail($videoId)
    {
        $video = Video::with(['course:id,course_heading'])->findOrFail($videoId);

        $progress = VideoUserProgress::with([
            'user:id,name,mobile',
            'video:id,title'
        ])
            ->where('video_id', $videoId)
            ->get();

        return view('students.student-video-detail', compact(
            'video',
            'progress'
        ));
    }


    public function studentStudyMaterialDetail($studentId, $materialId)
    {
        // Student
        $student = User::where('id', $studentId)
            ->where('type', 'student')
            ->firstOrFail();

        // Study Material
        $studyMaterial = StudyMaterial::findOrFail($materialId);

        // Order (purchase info)
        $order = Order::where('student_id', $studentId)
            ->where('package_id', $materialId)
            ->where('order_type', 'Study Material')
            ->first();

        return view('students.student-study-material-detail', compact(
            'student',
            'studyMaterial',
            'order'
        ));
    }
}
