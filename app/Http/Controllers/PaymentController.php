<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\StudyMaterial;
use App\Models\TestSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Cashfree's own payment_group codes -> readable label shown to admin/support
    private const PAYMENT_MODE_LABELS = [
        'upi' => 'UPI',
        'upi_ppi' => 'UPI',
        'upi_ppi_offline' => 'UPI (Offline)',
        'upi_credit_card' => 'UPI Credit Card',
        'credit_card' => 'Credit Card',
        'debit_card' => 'Debit Card',
        'credit_card_emi' => 'Credit Card EMI',
        'debit_card_emi' => 'Debit Card EMI',
        'cardless_emi' => 'Cardless EMI',
        'net_banking' => 'Net Banking',
        'wallet' => 'Wallet',
        'pay_later' => 'Pay Later',
        'paypal' => 'PayPal',
        'bank_transfer' => 'Bank Transfer',
        'prepaid_card' => 'Prepaid Card',
        'cash' => 'Cash',
    ];

    public function orderProcess(Request $request, $type, $id)
    {
        $user = User::find(Auth::user()->id);

        if ($type == 'course') {

            $course = Course::findOrFail($id);
            $fee = $course->course_fee;
            $discount = (float) ($course->discount ?? 0);
            $discountAmt = $discount > 0 ? $fee * ($discount / 100) : 0;
            $payAmount = $fee - $discountAmt;
            $package = 'Course';
            $order_note = $course->name;

        } else if ($type == 'study-material') {

            $study = StudyMaterial::findOrFail($id);
            $fee = (float) $study->mrp;
            $discount = (float) ($study->discount ?? 0);
            $discountAmt = ($discount > 0 && $study->IsPaid == 1) ? $fee * ($discount / 100) : 0;
            $payAmount = $fee - $discountAmt;
            $package = 'Study Material';
            $order_note = $study->title;

        } else if ($type == 'test-series') {

            $test = TestSeries::findOrFail($id);
            $fee = (float) $test->mrp;
            $discount = (float) ($test->discount ?? 0);
            $discountAmt = $discount > 0 ? $fee * ($discount / 100) : 0;
            $payAmount = $fee - $discountAmt;
            $package = 'Test Series';
            $order_note = $test->title;

        } else if ($type == 'paper') {

            $ids = explode(',', $id);
            $papers = Test::whereIn('id', $ids)->get();
            $fee = $papers->sum('offer_price');
            $discount = 0;
            $discountAmt = 0;
            $payAmount = $fee;
            $package = 'Paper';
            $order_note = 'PYQ Papers';

        }

        // ✅ WALLET REDEMPTION
        $requestedRedeem = (float) ($request->wallet_redeem_amount ?? 0);
        $walletUsed = 0;

        if ($requestedRedeem > 0) {
            $wallet = \App\Models\StudentWallet::where('student_id', $user->id)->lockForUpdate()->first();
            $walletBalance = $wallet->balance ?? 0;

            // Never trust the client figure — cap server-side
            $walletUsed = min($requestedRedeem, $walletBalance, $payAmount);

            if ($walletUsed > 0) {
                $wallet->decrement('balance', $walletUsed);
                $wallet->increment('total_debited', $walletUsed);

                \App\Models\StudentWalletTransaction::create([
                    'student_id' => $user->id,
                    'type' => 'debit',
                    'amount' => $walletUsed,
                    'source' => 'order_redemption',
                    'details' => 'Redeemed against ' . $order_note . ' purchase.',
                ]);
            }
        }

        $finalPayAmount = round($payAmount - $walletUsed, 2);

        // ✅ FULLY COVERED BY WALLET — skip Cashfree entirely
        if ($finalPayAmount <= 0) {
            $Order = new Order();
            $Order->order_code = 'ORDER_' . rand(111111, 999999);
            $Order->package_name = $order_note;
            $Order->package_id = $id;
            $Order->cust_id = 'CUST_' . rand(111111, 999999);
            $Order->student_id = $user->id;
            $Order->order_type = $package;
            $Order->billed_amount = $fee;
            $Order->quantity = 1;
            $Order->discount = $discount;
            $Order->discount_amount = $discountAmt;
            $Order->total = round($payAmount, 2);
            $Order->wallet_used = $walletUsed;
            $Order->payment_status = 'PAID';
            $Order->order_status = 'PAID';
            $Order->payment_mode = 'Wallet';
            $Order->payment_gateway = 'Wallet';
            $Order->payment_remark = 'Fully paid using wallet balance';
            $Order->save();

            $transaction = new Transaction();
            $transaction->order_id = $Order->id;
            $transaction->student_id = $user->id;
            $transaction->billed_amount = $fee;
            $transaction->payment_method = 'Wallet';
            $transaction->paid_amount = round($payAmount, 2);
            $transaction->payment_status = 'PAID';
            $transaction->payment_mode = 'Wallet';
            $transaction->payment_gateway = 'Wallet';
            $transaction->save();

            if ($package == 'Paper') {
                session()->forget('paper_cart');
            }

            return redirect()->route('thank.you', $Order->id);
        }

        // ✅ PARTIAL OR NO REDEMPTION — proceed to Cashfree for the remaining amount
        $url = "https://api.cashfree.com/pg/orders";

        $headers = [
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET'),
        ];

        $tags = [
            'package_type' => "$package",
            'package_id' => $id,
            'discount' => "$discount",
            'discount_amt' => "$discountAmt",
            'amount' => "$fee",
            'wallet_used' => "$walletUsed", // ✅ carried through so orderStatus can persist + refund if needed
        ];

        $data = json_encode([
            'order_id' => 'ORDER_' . rand(111111, 999999),
            'order_amount' => number_format($finalPayAmount, 2, '.', ''),
            "order_currency" => "INR",
            "order_note" => $order_note,
            'order_tags' => $tags,
            "customer_details" => [
                "customer_id" => 'CUST_' . rand(111111, 999999),
                "customer_name" => $user->name,
                "customer_email" => $user->email,
                "customer_phone" => $user->mobile,
            ],
            "order_meta" => [
                "return_url" => url('/') . '/order/status/?order_id={order_id}&order_token={order_token}',
            ],
        ]);

        $resp = $this->cashfreeCurl($url, $headers, 'POST', $data);

        if ($resp === null) {
            $this->refundWalletIfNeeded($walletUsed, $user->id, $order_note); // ✅ gateway never reached, give it back
            return redirect()->back()->with('error', 'Unable to connect to payment gateway. Please try again.');
        }

        $decoded = json_decode($resp);

        if (!isset($decoded->payment_link)) {
            $this->refundWalletIfNeeded($walletUsed, $user->id, $order_note); // ✅ order creation failed, give it back
            return redirect()->back()->with('error', 'Something went wrong while creating the payment order.');
        }

        return redirect()->to($decoded->payment_link);
    }

    /**
     * Credits redeemed wallet amount back if the Cashfree order never even got created.
     */
    private function refundWalletIfNeeded($walletUsed, $studentId, $orderNote)
    {
        if ($walletUsed <= 0) {
            return;
        }

        $wallet = \App\Models\StudentWallet::where('student_id', $studentId)->first();
        if ($wallet) {
            $wallet->increment('balance', $walletUsed);
            $wallet->decrement('total_debited', $walletUsed);

            \App\Models\StudentWalletTransaction::create([
                'student_id' => $studentId,
                'type' => 'credit',
                'amount' => $walletUsed,
                'source' => 'order_redemption_refund',
                'details' => 'Refunded — payment order for ' . $orderNote . ' could not be created.',
            ]);
        }
    }

    public function orderStatus(Request $request)
    {
        // ✅ Idempotency guard — prevents duplicate Order rows (and duplicate wallet refunds)
        // if the return URL is hit more than once for the same Cashfree order.
        $existing = Order::where('order_code', $request->order_id)->first();
        if ($existing) {
            return redirect()->route('thank.you', $existing->id);
        }

        $headers = [
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET'),
        ];

        $orderUrl = 'https://api.cashfree.com/pg/orders/' . $request->order_id;
        $orderResp = $this->cashfreeCurl($orderUrl, $headers);

        if ($orderResp === null) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $result = json_decode($orderResp);

        $created_at = $result->created_at;
        $customer_id = $result->customer_details->customer_id;
        $order_amount = $result->order_amount;
        $order_id = $result->order_id;
        $order_note = $result->order_note;
        $order_tags = $result->order_tags;
        $order_token = $result->order_token;
        $package_type = $order_tags->package_type;
        $package_id = $order_tags->package_id;
        $discount = $order_tags->discount;
        $discount_amt = $order_tags->discount_amt;
        $amount = $order_tags->amount;
        $walletUsed = (float) ($order_tags->wallet_used ?? 0); // ✅ pulled back from Cashfree tags

        $paymentsHeaders = array_map(
            fn($h) => str_starts_with($h, 'x-api-version:') ? 'x-api-version: 2022-09-01' : $h,
            $headers
        );
        $paymentsUrl = 'https://api.cashfree.com/pg/orders/' . $request->order_id . '/payments';
        $paymentsResp = $this->cashfreeCurl($paymentsUrl, $paymentsHeaders);
        $payments = $paymentsResp ? json_decode($paymentsResp) : [];

        [$paymentStatus, $paymentMode, $paymentRemark] = $this->resolvePaymentOutcome(
            is_array($payments) ? $payments : [],
            $result->order_status
        );

        $Order = new Order();
        $Order->order_code = $order_id;
        $Order->package_name = $order_note;
        $Order->package_id = $package_id;
        $Order->cust_id = $customer_id;
        $Order->student_id = Auth::user()->id;
        $Order->order_type = $package_type;
        $Order->billed_amount = $amount;
        $Order->quantity = 1;
        $Order->discount = $discount != "" ? $discount : 0;
        $Order->discount_amount = $discount_amt;
        $Order->total = round(((float) $amount) - ((float) $discount_amt), 2); // ✅ was: $Order->total = $order_amount;
        $Order->wallet_used = $walletUsed;
        $Order->transaction_id = $order_token;
        $Order->payment_status = $paymentStatus;
        $Order->order_status = $paymentStatus;
        $Order->payment_mode = $paymentMode;
        $Order->payment_gateway = 'CashFree';
        $Order->payment_remark = $paymentRemark;
        $Order->created_at = $created_at;

        // ✅ REFUND wallet if the gateway payment didn't succeed
        if ($walletUsed > 0 && $paymentStatus !== 'PAID') {
            $wallet = \App\Models\StudentWallet::where('student_id', Auth::id())->first();
            if ($wallet) {
                $wallet->increment('balance', $walletUsed);
                $wallet->decrement('total_debited', $walletUsed);

                \App\Models\StudentWalletTransaction::create([
                    'student_id' => Auth::id(),
                    'type' => 'credit',
                    'amount' => $walletUsed,
                    'source' => 'order_redemption_refund',
                    'details' => 'Refunded — payment ' . strtolower($paymentStatus) . ' for ' . $order_note . '.',
                ]);

                $Order->wallet_refunded = true;
            }
        }

        $Order->save();

        $transaction = new Transaction();
        $transaction->order_id = $Order->id;
        $transaction->student_id = Auth::user()->id;
        $transaction->billed_amount = $amount;
        $transaction->payment_method = $paymentMode ?? '';
        $transaction->paid_amount = $Order->total;
        $transaction->payment_status = $paymentStatus;
        $transaction->payment_mode = $paymentMode;
        $transaction->payment_gateway = 'CashFree';
        $transaction->transaction = $order_token;
        $transaction->created_at = $created_at;
        $transaction->save();

        if ($package_type == 'Paper' && $paymentStatus == 'PAID') {
            session()->forget('paper_cart');
        }

        return redirect()->route('thank.you', $Order->id);
    }

    public function thankYou($orderId)
    {
        $order = Order::findOrFail($orderId);

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

        return view('front.thank-you', compact(
            'order',
            'course',
            'studyMaterial',
            'testSeries',
            'papers'
        ));
    }

    /**
     * Decide final status (Success / Failed / Cancelled / Pending) + payment mode label
     * from the list of payment attempts Cashfree has recorded for this order.
     *
     * Cashfree payment_status values: SUCCESS, NOT_ATTEMPTED, FAILED, USER_DROPPED, VOID, CANCELLED, PENDING
     */
    private function resolvePaymentOutcome(array $payments, string $orderStatus): array
    {
        // No payment attempt recorded at all -> user never even tried (or Cashfree hasn't logged it yet)
        if (empty($payments)) {
            return ['Failed', null, 'No payment attempt recorded'];
        }

        // Take the most recent attempt (last one in the list, which Cashfree returns in chronological order)
        $latest = end($payments);

        $status = $latest->payment_status ?? 'FAILED';
        $group = $latest->payment_group ?? null;
        $mode = self::PAYMENT_MODE_LABELS[$group] ?? ($group ? ucfirst(str_replace('_', ' ', $group)) : null);

        $remark = $latest->payment_message
            ?? ($latest->error_details->error_description ?? null);

        return match ($status) {
            'SUCCESS' => ['PAID', $mode, $remark],
            'CANCELLED' => ['CANCELLED', $mode, $remark ?? 'Cancelled by user on payment page'],
            'USER_DROPPED' => ['FAILED', $mode, $remark ?? 'Payment window closed before completion'],
            'NOT_ATTEMPTED' => ['FAILED', $mode, 'Payment not attempted'],
            'PENDING' => ['PENDING', $mode, $remark ?? 'Awaiting confirmation from bank'],
            default => ['FAILED', $mode, $remark ?? 'Payment declined'], // FAILED, VOID, anything else
        };
    }

    /**
     * Shared curl helper for Cashfree calls. Returns response body string, or null on failure.
     */
    private function cashfreeCurl(string $url, array $headers, string $method = 'GET', ?string $data = null): ?string
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $resp = curl_exec($curl);
        $errored = curl_errno($curl) !== 0;

        if ($errored) {
            \Log::error('Cashfree API call failed: ' . curl_error($curl) . ' | URL: ' . $url);
        }

        curl_close($curl);

        return $errored ? null : $resp;
    }
}