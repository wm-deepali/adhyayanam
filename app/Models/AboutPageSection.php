<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageSection extends Model
{
    protected $fillable = [
        'section_key',
        'sub_title',
        'heading',
        'description',
        'image',
        'extra_data'
    ];

    protected $casts = [
        'extra_data' => 'array'
    ];
}