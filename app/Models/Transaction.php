<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table='transactions';

    protected $fillable=[
        'order_id',
        'student_id',
        'billed_amount',
        'paid_amount',
        'payment_status',
        'payment_method',
        'transaction',
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
