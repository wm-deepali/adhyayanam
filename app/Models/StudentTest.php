<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTest extends Model
{
    use HasFactory;
    protected $table = 'student_tests';
    protected $fillable = [
        'test_id',
        'student_id',
        'total_questions',
        'attempted',
        'not_attempted',
        'correct_answer',
        'wrong_answer',
        'total_marks',
        'score',
        'negative_marks',
        'duration',
        'taken_time',
        'status',
        
    ];
}
