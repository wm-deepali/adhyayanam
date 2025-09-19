<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSeries extends Model
{
    use HasFactory;

    protected $table = 'test_series';

    protected $fillable = [
        'title',
        'category_id',
        'logo',
        'language',
        'fee_type',
        'exam_com_id',
        'sub_category_id',
        'slug',
        'short_description',
        'description',
        'mrp',
        'price',
        'discount',
        'test_generated_by',
        'total_paper'
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'exam_com_id');
    }
    
    public function testseries(){
        return $this->hasMany(TestSeriesDetail::class, 'test_series_id');
    }
      public function tests()
    {
        return $this->hasManyThrough(Test::class, TestSeriesDetail::class, 'test_series_id', 'id', 'id', 'test_id');
    }
}
