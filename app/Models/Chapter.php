<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapter';

    protected $fillable = [
        'exam_com_id',
        'category_id',
        'sub_category_id',
        'subject_id',
        'name',
        'chapter_number',
        'description',
        'status',
        'created_by'
    ];

    // Define the relationship with the Subject model
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class, 'chapter_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
