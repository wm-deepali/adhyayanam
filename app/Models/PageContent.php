<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'section_key',
        'heading',
        'sub_heading'
    ];
}