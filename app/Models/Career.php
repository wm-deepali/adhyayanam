<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $table = 'career';
    protected $fillable = [
        'position',
        'name',
        'email',
        'mobile',
        'gender',
        'dob',
        'experience',
        'qualification',
        'message',
        'cv',
    ];
}
