<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
        'image',
        'button_name',
        'url',
        'sort_order',
        'status'
    ];
}