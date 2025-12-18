<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTopic extends Model
{
    use HasFactory;
    protected $table = 'course_topics';
    protected $fillable = [
        'exam_com_id',
        'category_id',
        'sub_category_id',
        'subject_id',
        'chapter_id',
        'name',
        'topic_number',
        'description',
        'status',
        'created_by'
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class, 'topic_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
