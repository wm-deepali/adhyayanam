<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;
    protected $table = 'study_material';

    protected $fillable = [
        'commission_id',
        'sub_category_id',
        'subject_id',
        'chapter_id',
        'category_id',
        'topic_id',
        'material_type',
        'is_pdf_downloadable',

        'title',
        'short_description',
        'detail_content',
        'status',
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


    protected $casts = [
        'is_pdf_downloadable' => 'boolean',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function topic()
    {
        return $this->belongsTo(CourseTopic::class, 'topic_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

}
