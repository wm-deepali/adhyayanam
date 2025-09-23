<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;

use App\Models\Teacher;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function show($id)
    {
        // dd('here');
        $teacher = Teacher::findOrFail($id);
        return view('teachers.profile.show', compact('teacher'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $teacher = auth()->guard('teacher')->user();
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        return redirect()->route('teacher.show', auth()->guard('teacher')->user()->id)
            ->with('status', 'Password changed successfully!');

    }

    public function TransactionsIndex()
    {
        $teacher = Teacher::findOrFail(Auth::id());

        $transactions = WalletTransaction::where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(10);

        return view('teachers.wallet.transactions', [
            'transactions' => $transactions,
            'balance' => $teacher->wallet_balance,
            'totalCredits' => WalletTransaction::where('teacher_id', $teacher->id)
                ->where('type', 'credit')
                ->sum('amount'),
            'totalDebits' => WalletTransaction::where('teacher_id', $teacher->id)
                ->where('type', 'debit')
                ->sum('amount'),
        ]);
    }

    public function withdrawRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $teacher = Auth::user();

        if ($request->amount > $teacher->wallet_balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance',
            ]);
        }

        // Store a withdrawal request (admin will process later)
        WithdrawalRequest::create([
            'teacher_id' => $teacher->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request submitted successfully!',
        ]);
    }

    public function withdrawalsIndex()
    {
        $teacherId = Auth::id();

        // Get all withdrawal requests for this teacher, latest first, paginated
        $withdrawalRequests = WithdrawalRequest::where('teacher_id', $teacherId)
            ->latest()
            ->paginate(10);

        // Optional: count pending requests for sidebar badge
        $pendingWithdrawalsCount = WithdrawalRequest::where('teacher_id', $teacherId)
            ->where('status', 'pending')
            ->count();

        return view('teachers.wallet.withdrawals', compact(
            'withdrawalRequests',
            'pendingWithdrawalsCount'
        ));
    }
}
