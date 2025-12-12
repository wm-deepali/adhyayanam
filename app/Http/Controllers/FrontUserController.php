<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\StudentTestAttempt;
use App\Models\StudyMaterial;
use App\Models\TestSeries;
use App\Models\Video;
use App\Models\VideoUserProgress;
use PDF;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;
use App\Models\StudentWallet;
use App\Models\StudentWalletTransaction;
use App\Models\WalletSetting;
use Illuminate\Support\Facades\Hash;
use App\Models\LogActivity as LogActivityModel;

class FrontUserController extends Controller
{
    public function studentRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'date_of_birth' => 'required|date_format:Y-m-d|before:12 years',
            'gender' => 'required|string',
            'password' => 'required|min:6|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name . " " . $request->last_name;
            $user->email = $request->email;
            $user->date_of_birth = $request->date_of_birth;
            $user->username = "10000" . $request->id;
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->save();

            // ✅ Wallet creation with welcome bonus
            $walletSetting = WalletSetting::first();
            $welcomeBonus = $walletSetting->welcome_bonus ?? 0;

            $wallet = StudentWallet::create([
                'student_id' => $user->id,
                'balance' => $welcomeBonus,
                'total_credited' => $welcomeBonus,
                'total_debited' => 0,
                'status' => 'active',
            ]);

            // ✅ Record first transaction
            if ($welcomeBonus > 0) {
                StudentWalletTransaction::create([
                    'student_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $welcomeBonus,
                    'source' => 'welcome_bonus',
                    'details' => 'Welcome bonus credited during registration.',
                ]);
            }

            DB::commit();
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Successfully Registered. Wallet created with welcome bonus of ₹' . $welcomeBonus,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function setting()
    {
        $logs = LogActivity::userLogActivityLists();
        return view('front-users.setting', compact('logs'));
    }


    public function activityDelete($id)
    {
        $log = LogActivityModel::findOrFail($id);
        $log->delete();
        return redirect()->route('user.setting')->with('success', 'Activity deleted successfully!');
    }

    public function studentChangePassword(Request $request)
    {

        $currentPasswordStatus = Hash::check($request->current_password, Auth::user()->password);

        if ($currentPasswordStatus) {

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password),
            ]);

            $user = User::find(Auth::user()->id);
            \LogActivity::addToLog('Password Update', $user);
            return response()->json([
                'success' => true,
                'message' => 'Password Updated Successfully',
            ]);

        } else {

            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Current Password does not match with Old Password',
            ]);
        }


    }
    public function studentAllOrder()
    {
        $data['orders'] = Order::with('student', 'transaction')
            ->where('student_id', Auth::user()->id)
            ->latest()
            ->get();
        return view('front-users.orders', $data);
    }

    public function orderDetails($id)
    {
        $data['order'] = Order::with('student', 'transaction')->where('id', $id)->first();
        return view('front-users.order-details', $data);
    }
    public function printInvoice($id)
    {
        $data['order'] = Order::with('student', 'transaction')->where('id', $id)->first();
        return view('front-users.invoice-pdf', $data);
    }

    public function generatePDF($id)
    {
        $data['order'] = Order::with('student', 'transaction')->where('id', $id)->first();
        $pdf = PDF::loadView('front-users.invoice-pdf', $data);
        return $pdf->download('invoice.pdf');
    }

    public function myCourses()
    {
        $studentId = Auth::id();

        $orders = Order::where('order_type', 'course')
            ->where('student_id', $studentId)
            ->where('payment_status', 'PAID')
            ->latest()
            ->get();

        foreach ($orders as $order) {
            $order->course = Course::find($order->package_id);
            // dd($order->course->toArray());
        }
        return view('front-users.courses', compact('orders'));
    }

    public function courseDetail($id)
    {
        $userId = auth()->id(); // current user
        $course = Course::findOrFail($id);

        if (strtolower($course->course_mode) == 'online') {
            $liveClasses = Video::with('teacher:id,full_name')
                ->where('course_id', $course->id)
                ->where('type', 'live_class')
                ->orderBy('schedule_date', 'asc')
                ->get();


            // Attach user progress
            $liveClasses->transform(function ($video) use ($userId) {
                $progress = $video->userProgress()->firstOrCreate(
                    ['user_id' => $userId],
                    [
                        'watched_count' => 0,
                        'access_till' => $video->access_till
                    ]
                );

                $video->watched_count = $progress->watched_count;
                $video->user_access_till = $progress->access_till;

                $video->is_valid =
                    (!$video->user_access_till || $video->user_access_till >= now()->toDateString()) &&
                    (!$video->no_of_times_can_view || $video->watched_count < $video->no_of_times_can_view);

                return $video;
            });

            return view('front-users.course-detail-live', compact('course', 'liveClasses'));
        }

        // Video Learning (LMS)
        $videoLessons = Video::where('course_id', $course->id)
            ->where('type', 'video')
            ->orderBy('created_at', 'asc')
            ->get();

        // Attach user progress
        $videoLessons->transform(function ($video) use ($userId) {
            $progress = $video->userProgress()->firstOrCreate(
                ['user_id' => $userId],
                [
                    'watched_count' => 0,
                    'access_till' => $video->access_till
                ]
            );
            $video->watched_count = $progress->watched_count;
            $video->user_access_till = $progress->access_till;

            $video->is_valid =
                (!$video->user_access_till || $video->user_access_till >= now()->toDateString()) &&
                (!$video->no_of_times_can_view || $video->watched_count < $video->no_of_times_can_view);

            return $video;
        });

        return view('front-users.course-detail-lms', compact('course', 'videoLessons'));
    }

    public function watch($id)
    {
        $userId = auth()->id();
        $video = Video::findOrFail($id);

        $progress = VideoUserProgress::firstOrCreate(
            ['user_id' => $userId, 'video_id' => $video->id],
            ['watched_count' => 0, 'access_till' => $video->access_till]
        );

        if ($video->no_of_times_can_view && $progress->watched_count >= $video->no_of_times_can_view) {
            return response()->json(['success' => false, 'message' => 'You have reached the maximum watching limit']);
        }

        if ($progress->access_till && $progress->access_till < now()->toDateString()) {
            return response()->json(['success' => false, 'message' => 'Validity expired']);
        }

        $progress->increment('watched_count');

        return response()->json(['success' => true, 'message' => 'Watch counted']);
    }

    public function StudyMaterial()
    {
        $studentId = Auth::id();

        $orders = Order::where('order_type', 'Study Material')
            ->where('student_id', $studentId)
            ->where('payment_status', 'PAID')
            ->latest()
            ->get();

        // Attach study material to each order
        foreach ($orders as $order) {
            $order->study_material = StudyMaterial::find($order->package_id);
        }

        return view('front-users.study-material', compact('orders'));
    }

    public function myTestSeries()
    {
        $studentId = Auth::id();

        // Fetch paid test series orders
        $paidOrders = Order::where('order_type', 'Test Series')
            ->where('student_id', $studentId)
            ->where('payment_status', 'PAID')
            ->latest()
            ->get();

        // Extract purchased IDs
        $purchasedIds = $paidOrders->pluck('package_id')->toArray();

        // Fetch Test Series Assignments for Purchased
        $testSeriesList = TestSeries::with('tests')
            ->whereIn('id', $purchasedIds)
            ->get()
            ->keyBy('id');

        foreach ($paidOrders as $order) {
            $order->test_series = $testSeriesList[$order->package_id] ?? null;
        }

        // Fetch FREE Test Series not already purchased
        $freeSeries = TestSeries::with('tests')
            ->where('fee_type', 'free')
            ->whereNotIn('id', $purchasedIds)
            ->get();

        // Fetch IDs of completed/attempted test papers by student
        $studentAttempts = StudentTestAttempt::where('student_id', $studentId)
            ->where('status', '!=', 'in_progress') // ⬅ EXCLUDE IN-PROGRESS TESTS
            ->pluck('test_id')
            ->toArray();

        return view('front-users.test-series', compact('paidOrders', 'freeSeries', 'studentAttempts'));
    }


    public function testSeriesDetail($slug)
    {
        $testseries = TestSeries::with('tests', 'testseries')->where('slug', $slug)->firstOrFail();

        return view('front-users.test-series-detail', compact('testseries'));
    }

    public function listUserTestPapers()
    {
        $studentId = auth()->id();

        $attemptedTests = StudentTestAttempt::with('test')
            ->where('student_id', $studentId)
            ->where('status', '!=', 'in_progress') // ⬅ EXCLUDE IN-PROGRESS TESTS
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front-users.test-paper', compact('attemptedTests'));
    }


}
