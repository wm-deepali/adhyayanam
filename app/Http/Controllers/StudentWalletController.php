<?php

namespace App\Http\Controllers;

use App\Models\StudentWallet;
use App\Models\StudentWalletTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\StudyMaterial;
use App\Models\TestSeries;
use App\Models\Test;
use Illuminate\Http\Request;
class StudentWalletController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();

        // Check if wallet exists, otherwise create one
        $wallet = StudentWallet::firstOrCreate(
            ['student_id' => $studentId],
            ['balance' => 0] // Default values when creating
        );

        $transactions = StudentWalletTransaction::where('student_id', $studentId)
            ->latest()
            ->paginate(10);

        return view('front-users.wallet.index', compact('wallet', 'transactions'));
    }

    public function checkBalance(Request $request)
    {
        $request->validate([
            'type' => 'required|in:course,study-material,test-series,paper',
            'id' => 'required',
        ]);

        $payAmount = $this->resolvePayAmount($request->type, $request->id);

        if ($payAmount === null) {
            return response()->json(['success' => false, 'message' => 'Package not found.']);
        }

        $wallet = StudentWallet::where('student_id', Auth::id())->first();
        $balance = $wallet->balance ?? 0;

        $maxRedeemable = min($balance, $payAmount);

        return response()->json([
            'success' => true,
            'wallet_balance' => round($balance, 2),
            'course_fee' => round($payAmount, 2),
            'max_redeemable' => round($maxRedeemable, 2),
            'has_balance' => $balance > 0,
        ]);
    }

    /**
     * Mirrors the fee/discount computation in PaymentController::orderProcess
     * so the amount shown in the wallet modal always matches what Cashfree will charge.
     */
    private function resolvePayAmount($type, $id)
    {
        if ($type == 'course') {
            $course = Course::find($id);
            if (!$course)
                return null;
            $fee = $course->course_fee;
            $discount = (float) ($course->discount ?? 0);
            $discountAmt = $discount > 0 ? $fee * ($discount / 100) : 0;
            return $fee - $discountAmt;
        }

        if ($type == 'study-material') {
            $study = StudyMaterial::find($id);
            if (!$study)
                return null;
            $fee = (float) $study->mrp;
            $discount = (float) ($study->discount ?? 0);
            $discountAmt = ($discount > 0 && $study->IsPaid == 1) ? $fee * ($discount / 100) : 0;
            return $fee - $discountAmt;
        }

        if ($type == 'test-series') {
            $test = TestSeries::find($id);
            if (!$test)
                return null;
            $fee = (float) $test->mrp;
            $discount = (float) ($test->discount ?? 0);
            $discountAmt = $discount > 0 ? $fee * ($discount / 100) : 0;
            return $fee - $discountAmt;
        }

        if ($type == 'paper') {
            $ids = explode(',', $id);
            $papers = Test::whereIn('id', $ids)->get();
            if ($papers->isEmpty())
                return null;
            return $papers->sum('offer_price');
        }

        return null;
    }


}
