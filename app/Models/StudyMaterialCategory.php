<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterialCategory extends Model
{
    use HasFactory;

    protected $table = 'study_material_categories';

    protected $fillable = [
        'name',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical_url',
        'image',
        'alt_tag',
        'status',
    ];

    
}
