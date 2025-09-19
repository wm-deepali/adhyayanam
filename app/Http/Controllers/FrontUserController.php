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
use PDF;
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
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'code' => 422,
                'errors'=>$validator->errors(),
            ]);
        }
       
        $user =  User::find($request->id);
        $user->first_name =  $request->first_name;
        $user->last_name =  $request->last_name;
        $user->name =  $request->first_name." ".$request->last_name;
        $user->email =  $request->email;
        $user->date_of_birth =  $request->date_of_birth;
        $user->username =  "10000".$request->id;
        $user->gender =  $request->gender;
        $user->password =  Hash::make($request->password);
        $user->save();
        Auth::login($user);
       
        return response()->json([
            'success' => true,
            'message' => 'Succesfully Registered',
        ]);
    }
    
    
    public function setting()
    {
        $logs = \LogActivity::userLogActivityLists();
        return view('front-users.setting',compact('logs'));
    }
    
    
    public function activityDelete($id){
        $log = LogActivityModel::findOrFail($id);
        $log->delete();
        return redirect()->route('user.setting')->with('success', 'Activity deleted successfully!');
    }
    
    public function studentChangePassword(Request $request)
    {
        
        $currentPasswordStatus = Hash::check($request->current_password, Auth::user()->password);
        
        if($currentPasswordStatus){

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            
              $user =  User::find(Auth::user()->id);
                \LogActivity::addToLog('Password Update',$user);
            return response()->json([
                'success' => true,
                'message' => 'Password Updated Successfully',
            ]);

        }else{

            return response()->json([
                'success'=>false,
                'code' => 422,
                'message'=>'Current Password does not match with Old Password',
            ]);
        }
      

    }
    public function studentAllOrder()
    {
        $data['orders'] = Order::with('student', 'transaction')->where('student_id', Auth::user()->id)->get();
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

}
