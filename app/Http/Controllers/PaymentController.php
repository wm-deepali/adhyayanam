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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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

    // ✅ Order statuses that are NOT yet final — a webhook/return-url hit is still
    // allowed to update the order while it's in one of these. PENDING was added
    // because Cashfree can send an intermediate PENDING webhook (e.g. UPI collect
    // waiting on bank confirmation) followed later by a final SUCCESS/FAILED
    // webhook for the SAME order. Without allowing PENDING here, that second,
    // final webhook would get silently swallowed by the idempotency guard and
    // the order would stay stuck on PENDING forever.
    private const UNRESOLVED_ORDER_STATUSES = ['INITIATED', 'PENDING'];

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
        $url = "https://sandbox.cashfree.com/pg/orders";
        $cfOrderId = 'ORDER_' . rand(111111, 999999);

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
            'wallet_used' => "$walletUsed", // ✅ carried through so orderStatus/webhook can persist + refund if needed
        ];

        $data = json_encode([
            'order_id' => $cfOrderId,
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
                "notify_url" => url('/') . '/payment/webhook/cashfree',
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

        // ✅ Create an INITIATED order row RIGHT NOW, before the customer even
        // reaches Cashfree's page. This guarantees every attempt has a DB record —
        // whether the customer completes payment, drops off, or the tab is closed.
        // The stale-order cleanup command (payments:resolve-stale) resolves any of
        // these that never come back through return_url or webhook.
        $Order = new Order();
        $Order->order_code = $cfOrderId;
        $Order->package_name = $order_note;
        $Order->package_id = $id;
        $Order->cust_id = $decoded->customer_details->customer_id ?? null;
        $Order->student_id = $user->id;
        $Order->order_type = $package;
        $Order->billed_amount = $fee;
        $Order->quantity = 1;
        $Order->discount = $discount;
        $Order->discount_amount = $discountAmt;
        $Order->total = round($payAmount, 2);
        $Order->wallet_used = $walletUsed;
        $Order->transaction_id = $decoded->order_token ?? null;
        $Order->payment_status = 'INITIATED';
        $Order->order_status = 'INITIATED';
        $Order->payment_mode = null;
        $Order->payment_gateway = 'CashFree';
        $Order->payment_remark = 'Redirected to payment gateway — awaiting customer action';
        $Order->save();

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
        $existing = Order::where('order_code', $request->order_id)->first();

        // ✅ Idempotency guard — if already resolved to a FINAL state (by webhook
        // or a previous hit of this same return URL), don't process again.
        // NOTE: PENDING is deliberately treated as "still unresolved" here — see
        // UNRESOLVED_ORDER_STATUSES comment above.
        if ($existing && !in_array($existing->order_status, self::UNRESOLVED_ORDER_STATUSES, true)) {
            return redirect()->route('thank.you', $existing->id);
        }

        if (!$existing) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $headers = [
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET'),
        ];

        $orderUrl = 'https://sandbox.cashfree.com/pg/orders/' . $request->order_id;
        $orderResp = $this->cashfreeCurl($orderUrl, $headers);

        if ($orderResp === null) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $result = json_decode($orderResp);

        $paymentsHeaders = array_map(
            fn($h) => str_starts_with($h, 'x-api-version:') ? 'x-api-version: 2022-09-01' : $h,
            $headers
        );
        $paymentsUrl = 'https://sandbox.cashfree.com/pg/orders/' . $request->order_id . '/payments';
        $paymentsResp = $this->cashfreeCurl($paymentsUrl, $paymentsHeaders);
        $payments = $paymentsResp ? json_decode($paymentsResp) : [];

        $Order = $this->resolveAndSaveOrder($existing, $result, is_array($payments) ? $payments : []);

        return redirect()->route('thank.you', $Order->id);
    }

    /**
     * ✅ Cashfree webhook endpoint — https://www.cashfree.com/docs/payments/online/webhooks/overview
     *
     * Catches status changes (SUCCESS / FAILED / USER_DROPPED / etc.) even when the
     * customer never comes back through return_url — e.g. they closed the tab,
     * lost network, or the browser redirect silently failed.
     *
     * Also catches the PENDING -> final-status transition: Cashfree can fire this
     * webhook MORE THAN ONCE for the same order_id — first with PENDING (e.g. a
     * UPI collect request still waiting on bank confirmation), then again later
     * with the final SUCCESS/FAILED once the bank responds. Both calls are
     * processed here as long as the order is still in an "unresolved" state.
     *
     * Register this route WITHOUT the standard web CSRF/auth middleware (Cashfree
     * calls it server-to-server, there's no logged-in session):
     *
     *   Route::post('/payment/webhook/cashfree', [PaymentController::class, 'cashfreeWebhook'])
     *       ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
     */
    public function cashfreeWebhook(Request $request)
    {
        // ✅ Per docs: "Cashfree generates the webhook signature based on the raw
        // payload, not the parsed payload." Must use the untouched raw body —
        // re-encoding it (e.g. via $request->all()/json_decode+re-encode) can
        // reformat decimals (170.00 -> 170) and break the signature match.
        $rawBody = $request->getContent();
        $signature = $request->header('x-webhook-signature');
        $timestamp = $request->header('x-webhook-timestamp');

        if (!$this->verifyWebhookSignature($signature, $timestamp, $rawBody)) {
            Log::warning('Cashfree webhook signature verification failed.');
            return response()->json(['status' => 'invalid signature'], 400);
        }

        // ✅ Cashfree uses "at-least-once" delivery, meaning the SAME webhook event
        // can legitimately arrive more than once (e.g. after a downtime recovery).
        // The docs recommend checking x-idempotency-header (available on webhook
        // version 2025-01-01+) to skip re-processing a payload we've already seen.
        //
        // IMPORTANT: this cache-based dedupe is per EVENT, not per ORDER — a fresh
        // PENDING -> SUCCESS event for the same order will have its own new
        // idempotency key and will NOT be skipped here. That's handled below by
        // the order_status check instead.
        $idempotencyKey = $request->header('x-idempotency-header');
        if ($idempotencyKey) {
            $cacheKey = 'cashfree_webhook_' . $idempotencyKey;
            if (Cache::has($cacheKey)) {
                return response()->json(['status' => 'ok (duplicate, already processed)']);
            }
            Cache::put($cacheKey, true, now()->addHours(24));
        }

        $payload = json_decode($rawBody);
        $orderId = $payload->data->order->order_id ?? null;

        if (!$orderId) {
            return response()->json(['status' => 'ignored, no order_id']);
        }

        $existing = Order::where('order_code', $orderId)->first();

        // Nothing to resolve, or already resolved to a FINAL state (PAID / FAILED /
        // CANCELLED) by the return_url flow or a previous webhook — just ack with
        // 200 so Cashfree doesn't keep retrying.
        //
        // ✅ PENDING is intentionally still allowed through here, so that the
        // later SUCCESS/FAILED webhook for this same order can update it instead
        // of getting swallowed and leaving the order stuck on PENDING forever.
        if (!$existing || !in_array($existing->order_status, self::UNRESOLVED_ORDER_STATUSES, true)) {
            return response()->json(['status' => 'ok']);
        }

        $headers = [
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET'),
        ];

        $orderUrl = 'https://sandbox.cashfree.com/pg/orders/' . $orderId;
        $orderResp = $this->cashfreeCurl($orderUrl, $headers);

        if ($orderResp === null) {
            // Return 500 (not 200) so Cashfree retries per the configured policy.
            return response()->json(['status' => 'could not verify with cashfree'], 500);
        }

        $result = json_decode($orderResp);

        $paymentsHeaders = array_map(
            fn($h) => str_starts_with($h, 'x-api-version:') ? 'x-api-version: 2022-09-01' : $h,
            $headers
        );
        $paymentsUrl = 'https://sandbox.cashfree.com/pg/orders/' . $orderId . '/payments';
        $paymentsResp = $this->cashfreeCurl($paymentsUrl, $paymentsHeaders);
        $payments = $paymentsResp ? json_decode($paymentsResp) : [];

        $this->resolveAndSaveOrder($existing, $result, is_array($payments) ? $payments : []);

        return response()->json(['status' => 'ok']);
    }

    /**
     * ✅ Shared finalize logic — used by BOTH orderStatus() (return_url) and
     * cashfreeWebhook(), so whichever fires first resolves the order and the
     * other one just no-ops via the idempotency check.
     *
     * Can be called more than once for the same order (PENDING, then later
     * SUCCESS/FAILED) — each call just overwrites order_status/payment_status
     * with whatever Cashfree's /payments endpoint currently reports as the
     * latest attempt outcome, so the row always reflects the current truth.
     */
    private function resolveAndSaveOrder(?Order $existing, $result, array $payments): Order
    {
        $order_tags = $result->order_tags;
        $walletUsed = (float) ($existing->wallet_used ?? ($order_tags->wallet_used ?? 0));

        [$paymentStatus, $paymentMode, $paymentRemark] = $this->resolvePaymentOutcome(
            $payments,
            $result->order_status
        );

        $Order = $existing ?? new Order();
        $Order->order_code = $result->order_id;
        $Order->package_name = $result->order_note;
        $Order->package_id = $order_tags->package_id;
        $Order->cust_id = $result->customer_details->customer_id;
        $Order->student_id = $Order->student_id ?? Auth::id();
        $Order->order_type = $order_tags->package_type;
        $Order->billed_amount = $order_tags->amount;
        $Order->quantity = 1;
        $Order->discount = $order_tags->discount != "" ? $order_tags->discount : 0;
        $Order->discount_amount = $order_tags->discount_amt;
        $Order->total = round(((float) $order_tags->amount) - ((float) $order_tags->discount_amt), 2);
        $Order->wallet_used = $walletUsed;
        $Order->transaction_id = $result->order_token;
        $Order->payment_status = $paymentStatus;
        $Order->order_status = $paymentStatus;
        $Order->payment_mode = $paymentMode;
        $Order->payment_gateway = 'CashFree';
        $Order->payment_remark = $paymentRemark; // ✅ this is what the admin panel should display
        $Order->created_at = $result->created_at;

        // ✅ REFUND wallet if the gateway payment didn't succeed (and hasn't been
        // refunded already). Deliberately does NOT refund on PENDING — only on a
        // final non-PAID outcome (FAILED/CANCELLED) — so a PENDING->SUCCESS
        // transition never triggers a spurious refund+re-debit cycle.
        if ($walletUsed > 0 && $paymentStatus !== 'PAID' && $paymentStatus !== 'PENDING' && !$Order->wallet_refunded) {
            $wallet = \App\Models\StudentWallet::where('student_id', $Order->student_id)->first();
            if ($wallet) {
                $wallet->increment('balance', $walletUsed);
                $wallet->decrement('total_debited', $walletUsed);

                \App\Models\StudentWalletTransaction::create([
                    'student_id' => $Order->student_id,
                    'type' => 'credit',
                    'amount' => $walletUsed,
                    'source' => 'order_redemption_refund',
                    'details' => 'Refunded — payment ' . strtolower($paymentStatus) . ' for ' . $result->order_note . '.',
                ]);

                $Order->wallet_refunded = true;
            }
        }

        $Order->save();

        $transaction = Transaction::where('order_id', $Order->id)->first() ?? new Transaction();
        $transaction->order_id = $Order->id;
        $transaction->student_id = $Order->student_id;
        $transaction->billed_amount = $order_tags->amount;
        $transaction->payment_method = $paymentMode ?? '';
        $transaction->paid_amount = $Order->total;
        $transaction->payment_status = $paymentStatus;
        $transaction->payment_mode = $paymentMode;
        $transaction->payment_gateway = 'CashFree';
        $transaction->transaction = $result->order_token;
        $transaction->created_at = $result->created_at;
        $transaction->save();

        if ($order_tags->package_type == 'Paper' && $paymentStatus == 'PAID') {
            session()->forget('paper_cart');
        }

        return $Order;
    }

    /**
     * Verifies the x-webhook-signature header per Cashfree's official docs:
     * https://www.cashfree.com/docs/payments/online/webhooks/overview
     *
     *   timestamp := header x-webhook-timestamp
     *   signedPayload := timestamp + rawBody
     *   expectedSignature := Base64Encode(HMACSHA256(signedPayload, secretKey))
     *
     * secretKey here is the dedicated webhook Secret Key shown on the endpoint's
     * Summary screen in the dashboard (Developers > Webhooks > your endpoint) —
     * store it as CASHFREE_WEBHOOK_SECRET in .env. This is separate per
     * environment (sandbox vs production each have their own).
     */
    private function verifyWebhookSignature(?string $signature, ?string $timestamp, string $rawBody): bool
    {
        $secret = env('CASHFREE_WEBHOOK_SECRET');

        if (!$signature || !$timestamp || !$secret) {
            return false;
        }

        $expected = base64_encode(hash_hmac('sha256', $timestamp . $rawBody, $secret, true));

        return hash_equals($expected, $signature);
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
     * Cashfree order_status values: ACTIVE, PAID, EXPIRED, TERMINATED, TERMINATION_REQUESTED
     */
    private function resolvePaymentOutcome(array $payments, string $orderStatus): array
    {
        if (empty($payments)) {
            if ($orderStatus === 'EXPIRED') {
                return ['FAILED', null, 'Payment session expired — customer never attempted payment'];
            }
            if ($orderStatus === 'TERMINATED' || $orderStatus === 'TERMINATION_REQUESTED') {
                return ['CANCELLED', null, 'Order was terminated before payment'];
            }
            return ['FAILED', null, 'No payment attempt recorded'];
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
            Log::error('Cashfree API call failed: ' . curl_error($curl) . ' | URL: ' . $url);
        }

        curl_close($curl);

        return $errored ? null : $resp;
    }
}