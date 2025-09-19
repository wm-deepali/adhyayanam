<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
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
use App\Helpers\Helper;

class StudentController extends Controller
{
    //
    public function studentProfile($id)
    {
        $data['profile'] = User::where('id',$id)->where('type', 'student')->first();
        $data['course'] = Helper:: getStuedntCourseData($id);
        $data['testSeries'] = Helper:: getStuedntTestSeriesData($id);
        $data['studyMaterial'] = Helper:: getStuedntStudyMaterialData($id);
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
       
        $user =  User::find($id);
        $user->password =  Hash::make($request->password);
        $user->save();
        \LogActivity::addToLog('Password Update',$user);

        return back()->with('success', "Password Changed Successfully");
    }

    public function studentTestSummery()
    {
        $students  = User::where('type', 'student')->withCount(['testSeriesOrder', 'testSeriesOrderAttempt', 'testSeriesOrderPending'])->get();
        if(isset($students) && count($students) > 0)
        {
            $students = $students->map(function ($row, $key) {
                $lastOrder = Helper::getStuedntTestSeriesData($row->id);
                $lastOrderCode = $lastOrder['lastOrderCode'] ?? '--';
                $row->last_order = $lastOrderCode;
                return $row;
            });
        }
        $data['students'] =$students;
       return view('students.student-test-series-summary', $data);
    }

    public function studentCourseSummery()
    {
        $students  = User::where('type', 'student')->withCount(['courseOrder', 'courseOrderAttempt', 'courseOrderPending'])->get();
        if(isset($students) && count($students) > 0)
        {
            $students = $students->map(function ($row, $key) {

                $lastOrder = Helper::getStuedntCourseData($row->id);
                $lastOrderCode = $lastOrder['lastOrderCode'] ?? '--';
                $row->last_order = $lastOrderCode;
                return $row;
            });
        }
        $data['students'] =$students;
        return view('students.student-course-summary', $data);
    }

    public function RegisterStudentList()
    {
        $students = User::where('type', 'student')->withSum('transactions', 'paid_amount')->withCount(['orders'])->get();
        
        if(isset($students) && count($students) > 0)
        {
            $students = $students->map(function ($row, $key) {
                $row->last_order = Helper:: getStuedntlastOrderID($row->id);
                return $row;
            });
        }
        $data['students'] =$students;
       // dd($data);
       return view('students.registered-student-list', $data);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }

    public function ViewAllOrder($id)
    {
        $data['orders'] = Order::with('student', 'transaction')->where('student_id', $id)->get();
        return view('students.student-all-orders', $data);
    }
    
    
}
