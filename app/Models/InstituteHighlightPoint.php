<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteHighlightPoint extends Model
{
    protected $fillable = ['highlight_id', 'icon_image', 'comment'];
}