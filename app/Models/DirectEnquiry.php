<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectEnquiry extends Model
{
    use HasFactory;
    protected $table = "direct_enquiries";
    protected $fillable = [
        'query_for',
        'full_name',
        'mobile',
        'email',
        'details',
        'file',
    ];
}
