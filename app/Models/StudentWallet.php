<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'balance',
        'total_credited',
        'total_debited',
        'status',
    ];

    public function transactions()
    {
        return $this->hasMany(StudentWalletTransaction::class, 'student_id', 'student_id');
    }
}
