<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteHighlight extends Model
{
    protected $fillable = [
        'image',
        'sub_title',
        'main_heading',
        'short_description',
        'sub_sub_title'
    ];

    public function points()
    {
        return $this->hasMany(InstituteHighlightPoint::class,'highlight_id');
    }
}
