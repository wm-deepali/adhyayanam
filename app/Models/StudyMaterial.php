<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

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
        'based_on'
    ];


    protected $casts = [
        'is_pdf_downloadable' => 'boolean',
        'subject_id' => 'array',
        'chapter_id' => 'array',
        'topic_id' => 'array',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

    public function getSubjectsAttribute(): mixed
    {
        $subjectIds = $this->subject_id ?? [];
        return Subject::whereIn('id', $subjectIds)->get();
    }

    public function getChaptersAttribute()
    {
        $chapterIds = $this->chapter_id ?? [];
        return Chapter::whereIn('id', $chapterIds)->get();
    }

    public function getTopicsAttribute()
    {
        $topicIds = $this->topic_id ?? [];
        return CourseTopic::whereIn('id', $topicIds)->get();
    }

    public function sections()
    {
        return $this->hasMany(StudyMaterialSection::class, 'study_material_id');
    }


}
