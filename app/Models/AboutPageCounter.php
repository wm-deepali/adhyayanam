<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageCounter extends Model
{
    protected $fillable = [
        'value',
        'label',
        'sort_order'
    ];
}