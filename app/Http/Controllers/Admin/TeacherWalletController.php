<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherWalletController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::latest();

        // Optional filter by teacher_id
        if ($request->has('teacher_id') && !empty($request->teacher_id)) {
            $query->where('id', $request->teacher_id);
        }

        $teachers = $query->paginate(15);
        return view('admin.teacher_wallet.index', compact('teachers'));
    }

    public function transactions(Request $request)
    {
        $teacher = null;

        // Check if teacher_id is provided in query string
        if ($request->has('teacher_id')) {
            $teacher = Teacher::find($request->teacher_id);
        }

        if ($teacher) {
            $transactions = $teacher->transactions()->latest()->paginate(20);
            $balance = $teacher->wallet_balance;
            $totalCredits = $teacher->transactions()->where('type', 'credit')->sum('amount');
            $totalDebits = $teacher->transactions()->where('type', 'debit')->sum('amount');
        } else {
            $transactions = WalletTransaction::with('teacher')->latest()->paginate(20);
            $balance = null;
            $totalCredits = null;
            $totalDebits = null;
        }

        return view('admin.teacher_wallet.transactions', compact('transactions', 'teacher', 'balance', 'totalCredits', 'totalDebits'));
    }


    public function withdrawalRequests(Request $request)
    {
        $query = WithdrawalRequest::with('teacher')->latest();

        // Apply status filter only if teacher_id is provided
        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id)
                ->where('status', 'approved'); // Only approved payouts for this teacher
        }

        $withdrawalRequests = $query->paginate(20);

        return view('admin.teacher_wallet.withdrawal_requests', compact('withdrawalRequests'));
    }


    public function updateWithdrawalStatus(Request $request, WithdrawalRequest $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'payment_date' => 'nullable|date',
            'reference_id' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Handle screenshot upload if provided
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $path = $file->store('withdrawal_screenshots', 'public');
            $withdrawal->screenshot = $path;
        }

        // Update withdrawal details
        if ($request->status === 'approved') {
            $withdrawal->payment_date = $request->payment_date;
            $withdrawal->reference_id = $request->reference_id;
            $withdrawal->remarks = $request->remarks;

            // Debit the amount from teacher's wallet
            $teacher = $withdrawal->teacher;
            if ($teacher && $teacher->wallet_balance >= $withdrawal->amount) {
                $teacher->wallet_balance -= $withdrawal->amount;
                $teacher->save();

                // Create a debit transaction record
                WalletTransaction::create([
                    'teacher_id' => $teacher->id,
                    'amount' => $withdrawal->amount,
                    'type' => 'debit',
                    'source' => 'withdrawal',
                    'details' => 'Withdrawal approved: Reference ID ' . $withdrawal->reference_id,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient wallet balance for this teacher.'
                ], 400);
            }
        }

        $withdrawal->processed_by = Auth::id(); // or Auth::user()->name
        $withdrawal->status = $request->status;
        $withdrawal->save();

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'withdrawal' => [
                'payment_date' => $withdrawal->payment_date?->format('d/m/Y'),
                'reference_id' => $withdrawal->reference_id,
                'remarks' => $withdrawal->remarks,
                'screenshot_url' => $withdrawal->screenshot ? asset('storage/' . $withdrawal->screenshot) : null
            ]
        ]);
    }

}
