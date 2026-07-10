<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\StudyMaterial;
use App\Models\Test;
use App\Models\TestSeries;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function AllOrder(Request $request)
    {
        $query = Order::with(['student:id,name,mobile'])
            ->latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%")
                    ->orWhere('order_type', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")

                    // 🔗 Student relation search
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        // 📄 PAGINATION (MAX 10 + KEEP SEARCH)
        $orders = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.student-all-orders', compact('orders'));
    }

    public function allTestSeriesOrder(Request $request)
    {
        $query = Order::with(['student:id,name,mobile', 'transaction'])
            ->where('order_type', 'Test Series')
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        if($request->filled('student_id')){
            $query->where('student_id', $request->student_id);
        }

        $orders = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.test-series-orders', compact('orders'));
    }

    public function allCourseOrder(Request $request)
    {
        $query = Order::with(['student:id,name,mobile', 'transaction'])
            ->where('order_type', 'Course')
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

         if($request->filled('student_id')){
            $query->where('student_id', $request->student_id);
        }

        $orders = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.course-orders', compact('orders'));
    }

    public function allStudyMaterialOrder(Request $request)
    {
        $query = Order::with(['student:id,name,mobile', 'transaction'])
            ->where('order_type', 'Study Material')
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.study-material-orders', compact('orders'));
    }

    public function allTransactions(Request $request)
    {
        $query = Transaction::with([
            'student:id,name,mobile',
            'order:id,order_code,wallet_used'
        ])
            ->latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('payment_method', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhere('paid_amount', 'like', "%{$search}%")

                    ->orWhereHas('order', function ($q2) use ($search) {
                        $q2->where('order_code', 'like', "%{$search}%");
                    })

                    ->orWhereHas('student', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.student-transactions-list', compact('transactions'));
    }

    public function allFailedTransactions(Request $request)
    {
        // NOTE: payment_status now stores 'Failed' / 'Cancelled' / 'Success' / 'Pending'
        // (set in PaymentController::resolvePaymentOutcome()). This screen shows both
        // Failed and Cancelled, since both mean the student did not complete payment --
        // support needs to see both to resolve queries.
        $query = Order::with(['student:id,name,mobile'])
            ->whereIn('payment_status', ['FAILED', 'CANCELLED', 'PENDING'])
            ->latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_mode', 'like', "%{$search}%")
                    ->orWhere('payment_remark', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(10)->appends($request->query());

        return view('order-subscriptions.student-failed-transactions', compact('transactions'));
    }

    public function studentOrderDetails($id)
    {
        $order = Order::with('student', 'transaction')->findOrFail($id);

        $course = null;
        $studyMaterial = null;
        $testSeries = null;
        $papers = null;

        if ($order->order_type == 'Course') {
            $course = Course::find($order->package_id);
        } elseif ($order->order_type == 'Study Material') {
            $studyMaterial = StudyMaterial::find($order->package_id);
        } elseif ($order->order_type == 'Test Series') {
            $testSeries = TestSeries::find($order->package_id);
        } elseif ($order->order_type == 'Paper') {

            $ids = explode(',', $order->package_id);

            $papers = Test::whereIn('id', $ids)->get();

        }
        return view('students.student-order-detail', compact(
            'order',
            'course',
            'studyMaterial',
            'testSeries',
            'papers'
        ));
    }
}