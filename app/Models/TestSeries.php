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
        'overview',
        'validity',
        'key_features',
        'mrp',
        'price',
        'discount',
        'test_generated_by',
        'total_paper',
        'created_by'
    ];

    protected $casts = [
        'key_features' => 'array',
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

    public function testseries()
    {
        return $this->hasMany(TestSeriesDetail::class, 'test_series_id');
    }

    public function tests()
    {
        return $this->hasManyThrough(Test::class, TestSeriesDetail::class, 'test_series_id', 'id', 'id', 'test_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'package_id')
            ->where('order_type', 'Test Series');
    }
}
