<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'teacher_id',
        'type',       // 'credit' or 'debit'
        'amount',     // decimal value
        'source',     // MCQ / Subjective / Story
        'details',    // optional extra info, e.g., question ID
    ];

    /**
     * Relation: Transaction belongs to a Teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
