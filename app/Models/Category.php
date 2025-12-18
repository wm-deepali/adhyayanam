<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'exam_com_id',
        'name',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical_url',
        'image',
        'alt_tag',
        'status',
        'created_by'
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    // Define the inverse relationship with ExaminationCommission
    public function examinationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'exam_com_id');
    }

    public function testSeries()
    {
        return $this->hasMany(TestSeries::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
