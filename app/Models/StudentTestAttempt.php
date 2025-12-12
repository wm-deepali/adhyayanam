<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'test_id',
        'status',
        'started_at',
        'completed_at',

        'total_questions',
        'attempted_count',
        'not_attempted',

        'correct_count',
        'wrong_count',

        'actual_marks',

        'earned_positive_score',
        'earned_negative_score',

        'max_positive_score',
        'max_negative_score',

        'final_score',

        'time_taken',

        // NEW FIELDS
        'final_file',
        'assigned_teacher_id'
    ];

    protected $dates = [
        'started_at',
        'completed_at'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function answers()
    {
        return $this->hasMany(StudentTestAnswer::class, 'attempt_id');
    }

    /** 🔥 NEW RELATIONSHIP */
    public function assignedTeacher()
    {
        return $this->belongsTo(Teacher::class, 'assigned_teacher_id');
    }

    public function getResultDivisionAttribute()
    {
        if (!$this->actual_marks || $this->actual_marks == 0) {
            return null;
        }

        $percentage = ($this->final_score / $this->actual_marks) * 100;

        $division = \App\Models\PercentageSystem::where('from_percentage', '<=', $percentage)
            ->where('to_percentage', '>=', $percentage)
            ->where('status', 'active')
            ->first();

        return $division ? $division->division : 'N/A';
    }

}
