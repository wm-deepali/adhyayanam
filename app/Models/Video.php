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
        'course_id',
        'chapter_id',
        'sub_category_id',
        'subject_id',
        'topic_id',
        'type',
        'title',
        'image',
        'cover_image',
        'content',
        'solution_file',
        'assignment_file',
        'live_link',
        'slug',
        'video_url',
        'video_type',
        'duration',
        'schedule_date',
        'start_time',
        'end_time',
        'teacher_id',
        'rating',
        'access_till',
        'status',
        'support',
        'no_of_times_can_view',
    ];


    // App\Models\Video.php
    protected $casts = [
        'course_type' => 'integer',
    ];

    public function examinationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'course_type');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'course_category');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function topic()
    {
        return $this->belongsTo(CourseTopic::class, 'topic_id');
    }

    public function userProgress()
    {
        return $this->hasMany(VideoUserProgress::class);
    }

    public function homeworkSubmissions()
    {
        return $this->hasMany(StudentHomeworkSubmission::class);
    }

}
