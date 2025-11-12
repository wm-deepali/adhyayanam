<?php

namespace App\Http\Controllers;

use App\Models\StudentWallet;
use App\Models\StudentWalletTransaction;
use Illuminate\Support\Facades\Auth;

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


}
