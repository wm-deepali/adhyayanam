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
        $data['profile'] = User::where('id', $id)->where('type', 'student')->first();
        $data['course'] = Helper::getStuedntCourseData($id);
        $data['testSeries'] = Helper::getStuedntTestSeriesData($id);
        $data['studyMaterial'] = Helper::getStuedntStudyMaterialData($id);
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
            $lastOrder = Helper::getStuedntTestSeriesData($row->id);
            $row->last_order = $lastOrder['lastOrderCode'] ?? '--';
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
            $lastOrder = Helper::getStuedntCourseData($row->id);
            $row->last_order = $lastOrder['lastOrderCode'] ?? '--';
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
            $row->last_order = Helper::getStuedntlastOrderID($row->id);
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


}
