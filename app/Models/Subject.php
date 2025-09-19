<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';

    protected $fillable = [
        'exam_com_id',
        'category_id',
        'sub_category_id',
        'name',
        'subject_code',
        'status',
    ];

    // Define the relationship with SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'exam_com_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'subject_id');
    }

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class, 'subject_id');
    }
    public function pyqSubject()
    {
        return $this->hasMany(PyqSubject::class, 'subject_id');
    }
}
