<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMobiileVerification extends Model
{
    use HasFactory;
    protected $table="user_mobile_verification";
    protected $fillable=[
        'mobile_number','otp','verified'
        ];
}
