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
        'added_by_id',
        'added_by_type',
        'rejected_by'
    ];

    /**
     * Remove inline color styles from HTML.
     */
    protected function cleanHtml($value)
    {
        if (empty($value)) {
            return $value;
        }

        return preg_replace('/color\s*:\s*[^;"]+;?/i', '', $value);
    }

    /**
     * Automatically clean HTML when reading.
     */
    public function getQuestionAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getOptionAAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getOptionBAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getOptionCAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getOptionDAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getOptionEAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getInstructionAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getSolutionAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    public function getAnswerFormatAttribute($value)
    {
        return $this->cleanHtml($value);
    }

    // Relationships

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
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
        return $this->belongsTo(CourseTopic::class, 'topic', 'id');
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

    public function addedBy()
    {
        return $this->morphTo(__FUNCTION__, 'added_by_type', 'added_by_id');
    }
}