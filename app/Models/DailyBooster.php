<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyBooster extends Model
{
    use HasFactory;
    protected $table = 'daily_booster';

    protected $fillable = [
        'title',
        'start_date',
        'youtube_url',
        'short_description',
        'detail_content',
        'thumbnail',
        'image_alt_tag',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];
}
