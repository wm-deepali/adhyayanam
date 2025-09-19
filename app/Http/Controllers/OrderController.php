<?php

namespace App\Http\Controllers;
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
    public function AllOrder()
    {
        $data['orders'] = Order::all();
        return view('order-subscriptions.student-all-orders', $data);
    }
    public function allTestSeriesOrder()
    {
        $data['orders'] = Order::with('student', 'transaction')->where('order_type', 'Test Series')->get();
        return view('order-subscriptions.test-series-orders', $data);
    }

    public function allCourseOrder()
    {
        $data['orders'] = Order::with('student', 'transaction')->where('order_type', 'Course')->get();
        return view('order-subscriptions.course-orders', $data);
    }

    public function allStudyMaterialOrder()
    {
        $data['orders'] = Order::with('student', 'transaction')->where('order_type', 'Study Material')->get();
        return view('order-subscriptions.study-material-orders', $data);
    }
    public function allTransactions()
    {
        $data['transactions'] = Transaction::all();
        return view('order-subscriptions.student-transactions-list', $data);
    }
    public function allFailedTransactions()
    {
        $data['transactions'] = Order::with('student', 'order')->where('payment_status', 'failed')->get();
        return view('order-subscriptions.student-failed-transactions', $data);
    }

    public function studentOrderDetails($id)
    {
        $data['order'] = Order::with('student', 'transaction')->where('id', $id)->first();
        return view('students.student-order-detail', $data);
    }
}
