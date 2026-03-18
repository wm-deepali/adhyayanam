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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    //
    public function AllOrder(Request $request)
    {
        $query = Order::with('student')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%")
                    ->orWhere('order_type', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order-subscriptions.student-all-orders', compact('orders'));
    }

    public function allTestSeriesOrder(Request $request)
    {
        $query = Order::with(['student', 'transaction'])
            ->where('order_type', 'Test Series')
            ->latest();

        // 🔍 Server-side search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order-subscriptions.test-series-orders', compact('orders'));
    }

    public function allCourseOrder(Request $request)
    {
        $query = Order::with(['student', 'transaction'])
            ->where('order_type', 'Course')
            ->latest();

        // 🔍 Server-side search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order-subscriptions.course-orders', compact('orders'));
    }

    public function allStudyMaterialOrder(Request $request)
    {
        $query = Order::with(['student', 'transaction'])
            ->where('order_type', 'Study Material')
            ->latest();

        // 🔍 Server-side search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order-subscriptions.study-material-orders', compact('orders'));
    }

    public function allTransactions(Request $request)
    {
        $query = Transaction::with(['student', 'order'])
            ->latest();
        // 🔍 Server-side search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('payment_method', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
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

        $transactions = $query->paginate(10)->withQueryString();

        return view('order-subscriptions.student-transactions-list', compact('transactions'));
    }

    public function allFailedTransactions(Request $request)
    {
        $query = Order::with('student')
            ->where('payment_status', 'failed')
            ->latest();

        // 🔍 Server-side search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('billed_amount', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

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
