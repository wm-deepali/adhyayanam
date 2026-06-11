<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageHighlight extends Model
{
    protected $fillable = [
        'icon',
        'heading',
        'short_description',
        'sort_order'
    ];
}