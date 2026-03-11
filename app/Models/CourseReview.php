<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'rating',
        'review'
    ];

    /**
     * Course relationship
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Student relationship
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}