<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PyqContent extends Model
{
    use HasFactory;
    protected $table = 'pyq_content';
    protected $fillable = [
        'commission_id',
        'category_id',
        'sub_category_id',
        'subject_id',
        'heading',
        'detail_content',
    ];

    public function examinationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function subject()
    {
        return $this->belongsTo(subject::class, 'subject_id');
    }
}
