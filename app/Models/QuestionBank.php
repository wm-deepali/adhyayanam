<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;
    protected $table = 'question_bank';
    protected $fillable = [
        'language',
        'question_category',
        'question_type',
        'previous_year',
        'commission_id',
        'category_id',
        'sub_category_id',
        'subjetc_id',
        'chapter_id',
        'topic',
        'has_instruction',
        'instruction',
        'has_option_e',
        'question'
    ];
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

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_bank_id');
    }
    
}
