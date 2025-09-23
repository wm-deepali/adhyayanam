<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDetail extends Model
{
    use HasFactory;

    protected $fillable=[
        'test_id',
        'question_id',
    ];
    
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
