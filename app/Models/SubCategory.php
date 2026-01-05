<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_category';

    protected $fillable = [
        'examination_commission_id',
        'category_id',
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

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'sub_category_id');
    }

    public function ExaminationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'examination_commission_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
