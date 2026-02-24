<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeEnquiry extends Model
{
    protected $fillable = [
        'full_name',
        'email_address',
        'country_code',
        'mobile_number',
        'message',
    ];
}
