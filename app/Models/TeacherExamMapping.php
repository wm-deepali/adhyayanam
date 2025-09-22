<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherExamMapping extends Model
{
    use HasFactory;

    protected $table = 'teacher_exam_mappings';

    protected $fillable = [
        'teacher_id',
        'exam_type_id',
        'category_id',
        'sub_category_id',
        'subject_id',
    ];

    // 🔹 Relationships

    // Teacher mapping belongs to a teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Exam type (ExaminationCommission)
    public function examType()
    {
        return $this->belongsTo(ExaminationCommission::class, 'exam_type_id');
    }

    // Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Sub-category
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
