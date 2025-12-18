<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeFeature extends Model
{
    use HasFactory;

    protected $table = 'programme_feature';

    // The attributes that are mass assignable.
    protected $fillable = [
        'banner',
        'title',
        'short_description',
        'heading',
        'feature',
        'icon1',
        'icon2',
        'icon3',
        'icon4',
        'icon_title1',
        'icon_title2',
        'icon_title3',
        'icon_title4',
        'created-by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
