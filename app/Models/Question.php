<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';

    protected $fillable = [
        'language',
        'question_category',
        'question_type',
        'fee_type',
        'previous_year',
        'commission_id',
        'category_id',
        'sub_category_id',
        'subject_id',
        'chapter_id',
        'topic',
        'has_instruction',
        'instruction',
        'has_option_e',
        'show_on_pyq',
        // 'question_bank_id',
        'question',
        'answer',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'image',
        'passage_question_type',
        'answer_format',
        'has_solution',
        'solution',
        'status',
        'note',
    ];

    // public function questionBank()
    // {
    //     return $this->belongsTo(QuestionBank::class, 'question_bank_id');
    // }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function topics()
    {
        return $this->belongsTo(CourseTopic::class, 'topic','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

    public function questionDeatils()
    {
        return $this->hasMany(QuestionDetail::class, 'question_id');
    }
}
