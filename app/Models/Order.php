<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table='orders';

    protected $fillable=[
        'order_code',
        'package_name',
        'cust_id',
        'student_id',
        'order_type',
        'detail',
        'billed_amount',
        'quantity',
        'discount',
        'discount_amount',
        'tax',
        'total',
        'payment_status',
        'transaction_id',
        'order_status',
        'attempt_status',
        'created_at',
        'updated_at',
    ];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
