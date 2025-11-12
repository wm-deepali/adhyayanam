<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'amount',
        'source',
        'details',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
