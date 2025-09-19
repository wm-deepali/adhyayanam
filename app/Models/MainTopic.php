<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainTopic extends Model
{
    use HasFactory;
    protected $table="main_topics";
    protected $fillable=[
        'name',
        'category_id',
        'description',
        'image',
        'alt_tag',
    ];

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class, 'topic_id');
    }


    public function studycategory()
    {
        return $this->belongsTo(StudyMaterialCategory::class, 'category_id');
    }

    
}
