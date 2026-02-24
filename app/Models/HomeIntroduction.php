<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeIntroduction extends Model
{
    protected $fillable = [
        'heading',
        'description',
        'image',
        'updated_by'
    ];

    public function highlights()
    {
        return $this->hasMany(HomeIntroHighlight::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}