<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'feature';

    protected $fillable = [
        'heading',
        'title1',
        'title2',
        'title3',
        'icon1',
        'icon2',
        'icon3',
        'short_description1',
        'short_description2',
        'short_description3',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
