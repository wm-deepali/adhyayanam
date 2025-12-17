<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentHomeworkSubmission extends Model
{
    protected $table = 'student_homework_submissions';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'video_id',
        'assignment_file',
        'submitted_at',
        'teacher_remark',
        'marks',
        'status',
        'checked_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'checked_at'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Student who submitted homework
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Teacher who reviewed homework
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // Related live class
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
