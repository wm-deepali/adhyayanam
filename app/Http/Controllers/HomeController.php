<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\TestSeries;
use App\Models\Course;
use App\Models\StudyMaterial;
use App\Models\Video;
use App\Models\StudentTestAttempt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        $totalOrders = Order::count();
        $successfulPayments = Order::where('payment_status', 'PAID')->sum('billed_amount');
        $failedPayments = Order::where('payment_status', 'failed')->sum('billed_amount');
        $studentRegistered = User::where('type', 'student')->whereNull('deleted_at')->count();

        $totalTestSeries = TestSeries::count();
        $totalCourses = Course::count();
        $totalStudyMaterials = StudyMaterial::count();
        $totalLmsVideos = Video::where('type', 'video')->count();

        $totalTestAttempted = StudentTestAttempt::count();
        $resultDeclared = StudentTestAttempt::where('status', 'published')->count();
        $resultsPending = StudentTestAttempt::where('status', 'under_review')->count();
        $testPending = StudentTestAttempt::where('status', 'pending')->count();

        $recentStudents = User::where('type', 'student')
            ->latest()
            ->take(10)
            ->get();

        $recentOrders = Order::with('student', 'transaction')
            ->latest()
            ->take(10)
            ->get();

        $recentAttempts = StudentTestAttempt::with(['student', 'test'])
            ->latest()
            ->take(10)
            ->get();


        return view('dashboard', compact(
            'totalOrders',
            'successfulPayments',
            'failedPayments',
            'studentRegistered',
            'totalTestSeries',
            'totalCourses',
            'totalStudyMaterials',
            'totalLmsVideos',
            'totalTestAttempted',
            'resultDeclared',
            'resultsPending',
            'testPending',
            'recentStudents',
            'recentOrders',
            'recentAttempts'
        ));
    }

    public function about()
    {
        return view('about');
    }
}
