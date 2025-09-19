<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\StudyMaterial;
use App\Models\TestSeries;
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


class PaymentController extends Controller
{
    //
    public function orderProcess($type, $id)
    {
          $user = User::find(Auth::user()->id);
          if($type=='course')
          {    
               $course = Course::find($id);
               //instantiate the class
               $fee= $course->course_fee;
               $discount = $course->discount;
               if($discount !='' && $discount > 0)
               {
                    $discountAmt = $fee*($discount/100);
               }
               else{
                    $discountAmt = 0;
               }
               $payAmount = $fee - $discountAmt;
               $package = 'Course';
               $order_note = $course->name;
          }
          else if($type=='study-material')
          {    
               $study = StudyMaterial::find($id);
               //instantiate the class
               $fee= $study->mrp;
               $discount = $study->discount;
               if($discount !='' && $discount > 0 && $study->IsPaid == 1)
               {
                    $discountAmt = $fee*($discount/100);
               }
               else{
                    $discountAmt = 0;
               }
               $payAmount = $fee - $discountAmt;
               $package = 'Study Material';
               $order_note = $study->title;
          }
          else if($type=='test-series')
          {    
               $test = TestSeries::find($id);
               //instantiate the class
               $fee= $test->mrp;
               $discount = $test->discount;
               if($discount !='' && $discount > 0)
               {
                    $discountAmt = $fee*($discount/100);
               }
               else{
                    $discountAmt = 0;
               }
               $payAmount = $fee - $discountAmt;
               $package = 'Test Series';
               $order_note = $test->title;
          }
        
        
        
        $url = "https://sandbox.cashfree.com/pg/orders";

        $headers = array(
             "Content-Type: application/json",
             "x-api-version: 2022-01-01",
             "x-client-id: ".env('CASHFREE_API_KEY'),
             "x-client-secret: ".env('CASHFREE_API_SECRET')
        );
        $tags = array('package_type'=>"$package", 'package_id'=>$id, 'discount'=>"$discount", 'discount_amt'=>"$discountAmt", 'amount'=>"$fee");
        
        $data = json_encode([
             'order_id' =>  'ORDER_'.rand(111111,999999),
             'order_amount' => $payAmount,
             "order_currency" => "INR",
             "order_note" => $order_note,
             'order_tags' => $tags,
             "customer_details" => [
                  "customer_id" => 'CUST_'.rand(111111,999999),
                  "customer_name" => $user->name,
                  "customer_email" => $user->email,
                  "customer_phone" => $user->mobile,
             ],
             "order_meta" => [
                  "return_url" => url('/').'/order/status/?order_id={order_id}&order_token={order_token}',
                  
             ]
        ]);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);    
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $resp = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        
        curl_close($curl);
        //dd($resp);
        if(isset($error_msg))
        {
          dd($error_msg);
        }
        return redirect()->to(json_decode($resp)->payment_link);
    }
    
    public function orderStatus(Request $request)
     {
          $headers = array(
               "Content-Type: application/json",
               "x-api-version: 2022-01-01",
               "x-client-id: ".env('CASHFREE_API_KEY'),
               "x-client-secret: ".env('CASHFREE_API_SECRET')
          );
          $url ='https://sandbox.cashfree.com/pg/orders/'.$request->order_id;
          $curl = curl_init($url);

         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);    
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        
        curl_close($curl);
        if(!isset( $error_msg))
        {
          $result = json_decode($resp);
          $created_at = $result->created_at;
          $customer_id = $result->customer_details->customer_id;
          $order_amount = $result->order_amount;
          $order_id = $result->order_id;
          $payment_methods = $result->order_meta->payment_methods;
          $order_note = $result->order_note;
          $order_status = $result->order_status;
          $order_tags = $result->order_tags;
          $order_token = $result->order_token;
          $package_type = $order_tags->package_type;
          $package_id = $order_tags->package_id;
          $discount = $order_tags->discount;
          $discount_amt = $order_tags->discount_amt;
          $amount = $order_tags->amount;

          $Order = new Order();
          $Order->order_code = $order_id;
          $Order->package_name = $order_note;
          $Order->package_id = $package_id;
          $Order->cust_id = $customer_id;
          $Order->student_id = Auth::user()->id;
          $Order->order_type = $package_type;
          $Order->billed_amount = $amount;
          $Order->quantity = 1;
          $Order->discount = $discount;
          $Order->discount_amount = $discount_amt;
          $Order->total = $order_amount;
          $Order->payment_status = $order_status;
          $Order->transaction_id = $order_token;
          $Order->order_status = $order_status;
          $Order->created_at = $created_at;
          $Order->save();

          $transaction = new Transaction();
          $transaction->order_id = $Order->id;
          $transaction->student_id = Auth::user()->id;
          $transaction->billed_amount = $amount;
          $transaction->payment_method = $payment_methods ?? '';
          $transaction->paid_amount = $order_amount;
          $transaction->payment_status = $order_status;
          $transaction->transaction = $order_token;
          $transaction->created_at = $created_at;
          $transaction->save();
          if($package_type == 'Course')
          {
               return redirect()->route('courses.detail', $package_id)->with('success', 'Enrolled successfully!');
          }
          else if($package_type == 'Study Material')
          {
               return redirect()->route('study.material.details', $package_id)->with('success', 'Buy successfully!');
          }
          else if($package_type == 'Test Series')
          {
               $test = TestSeries::find($package_id);
               return redirect()->route('test-series-detail', $test->slug)->with('success', 'Buy successfully!');
          }
          

        }
        else{
          return redirect()->back()->with('error', 'Something went wrong!');
        }
        
     }
}
