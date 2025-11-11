<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_code',
        'language',
        'paper_type',
        'previous_year',
        'test_type',

        'competitive_commission_id',
        'exam_category_id',
        'exam_subcategory_id',

        'chapter_id',
        'topic_id',
        'subject_id',
        'name',
        'duration',

        'total_questions',
        'total_marks',
        'test_instruction',


        'question_shuffling',
        'allow_re_attempt',
        'number_of_re_attempt_allowed',
        'has_negative_marks',

        'total_questions_mcq',
        'total_marks_mcq',

        'non_section_details',

        'question_marks_details',
        'positive_marks_per_question',
        'negative_marks_per_question',

        'mcq_total_question',
        'mcq_mark_per_question',
        'mcq_total_marks',

        'story_total_question',
        'story_mark_per_question',
        'story_total_marks',

        'subjective_total_question',
        'subjective_mark_per_question',
        'subjective_total_marks',
        'test_paper_type',
        'question_generated_by',

        'mrp',
        'discount',
        'offer_price'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'exam_category_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
    public function testDetails()
    {
        return $this->hasMany(TestDetail::class, 'test_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'exam_subcategory_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'competitive_commission_id');
    }


}