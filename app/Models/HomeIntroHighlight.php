<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeIntroHighlight extends Model
{
    protected $fillable = [
        'home_introduction_id',
        'text'
    ];

    public function introduction()
    {
        return $this->belongsTo(HomeIntroduction::class);
    }
}