<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';

    protected $fillable = [
        'examination_commission_id',
        'category_id',
        'sub_category_id',
        'name',
        'duration',
        'course_fee',
        'discount',
        'offered_price',
        'num_classes',
        'num_topics',
        'language_of_teaching',
        'course_heading',
        'short_description',
        'course_overview',
        'detail_content',
        'thumbnail_image',
        'banner_image',
        'youtube_url',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'image_alt_tag',
        'feature',
    ];

    // Define relationships
    public function examinationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'examination_commission_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
