<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $table = 'syllabus';

    protected $fillable = [
        'commission_id',
        'category_id',
        'sub_category_id',
        'subject_id',
        'title',
        'type',
        'pdf',
        'detail_content',
        'status',
        'created_by'
    ];

    /**
     * Relationships
     */

    public function commission()
    {
        return $this->belongsTo(\App\Models\ExaminationCommission::class, 'commission_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(\App\Models\SubCategory::class, 'sub_category_id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
