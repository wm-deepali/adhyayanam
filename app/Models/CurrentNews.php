<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentNews extends Model
{
    protected $fillable = [
        'title',
        'type',
        'short_description',
        'detail_content',
        'image',
        'file',
        'url',
        'status'
    ];
}