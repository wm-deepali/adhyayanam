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
        'subject_id',
        'chapter_id',
        'topic_id',
        'based_on',
        'course_mode',
        'created_by'
    ];

    protected $casts = [
        'subject_id' => 'array',
        'chapter_id' => 'array',
        'topic_id' => 'array',
    ];

    // 🔹 Relationships
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

    // 🔹 Relationship for Subjects (if IDs stored as array)
    public function subjects()
    {
        return Subject::whereIn('id', $this->subject_id ?? [])->get();
    }

    // 🔹 Relationship for Chapters
    public function chapters()
    {
        return Chapter::whereIn('id', $this->chapter_id ?? [])->get();
    }

    // 🔹 Relationship for Topics
    public function topics()
    {
        return CourseTopic::whereIn('id', $this->topic_id ?? [])->get();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
