<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionDetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'question_id',
        'question',
        'answer',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'has_option_e',
        'answer_format'
    ];
}
