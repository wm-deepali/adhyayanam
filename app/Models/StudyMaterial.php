<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;
    protected $table = 'study_material';

    protected $fillable = [
        'category_id',
        'topic_id',
        'title',
        'short_description',
        'detail_content',
        'status',
        'pdf',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'subject_id',
        'banner',
        'IsPaid',
        'mrp',
        'discount',
        'price',
    ];

    

    public function studycategory()
    {
        return $this->belongsTo(StudyMaterialCategory::class, 'category_id');
    }

    public function maintopic()
    {
        return $this->belongsTo(MainTopic::class, 'topic_id');
    }
}
