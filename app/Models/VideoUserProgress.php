<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoUserProgress extends Model
{
    protected $fillable = ['user_id', 'video_id', 'watched_count', 'access_till'];
}
