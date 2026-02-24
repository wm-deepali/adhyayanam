<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteFeature extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'image',
        'sort_order',
        'status'
    ];
}