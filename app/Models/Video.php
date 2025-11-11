<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    protected $fillable = [
        'course_type',
        'course_category',
        'access_till',
        'duration',
        'rating',
        'cover_image',
        'course_id',
        'chapter_id',
        'type',
        'title',
        'image',
        'content',
        'assignment',
        'slug',
        'video_url',
        'video_type',
        'schedule_date',
        'start_time',
        'end_time',
        'teacher_id',
        'status',
        'support',
        'no_of_times_can_view',
        'asignment',
        'sub_category_id',
        'subject_id',
        'topic_id'

    ];

    public function coursecategory()
    {
        return $this->belongsTo(Category::class, 'course_category');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

}
