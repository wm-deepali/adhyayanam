<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'parent_question_id',
        'answer_key',
        'answer_text',
        'answer_file',
        'child_responses',
        'obtained_marks',
        'requires_manual_check',
        'answered_at',
        'attempt_status',
        'evaluation_status',
        'positive_mark',
        'negative_mark',

        // NEW FIELDS
        'teacher_remarks',
        'teacher_file',
        'admin_remarks',
        'admin_file',
    ];

    protected $casts = [
        'child_responses'       => 'array',
        'answered_at'           => 'datetime',
        'requires_manual_check' => 'boolean',
        'obtained_marks'        => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function attempt()
    {
        return $this->belongsTo(StudentTestAttempt::class, 'attempt_id');
    }

    /**
     * IMPORTANT:
     * question_id represents:
     * Normal Questions => questions.id
     * Child Questions  => question_details.id
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function childQuestion()
    {
        return $this->belongsTo(QuestionDetail::class, 'question_id');
    }
}
