<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallBack extends Model
{
    use HasFactory;
    
    protected $table = 'call_back_inquiries';
    protected $fillable = [
        'query_for',
        'full_name',
        'mobile',
        'email',
    ];
}
