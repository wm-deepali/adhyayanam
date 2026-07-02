<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardBannerSetting extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
    ];
}