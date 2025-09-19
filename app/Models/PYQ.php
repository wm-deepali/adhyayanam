<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PYQ extends Model
{
    use HasFactory;
    protected $table = 'pyqs';
    
    protected $fillable = [
        'paper_type',
        'year',
        'commission_id',
        'category_id',
        'sub_cat_id',
        'has_subject',
        'pdf',
        'title',
        'status',
    ];
    
    public function examinationCommission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }
    
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id');
    }

    
    public function commission()
    {
        return $this->belongsTo(ExaminationCommission::class, 'commission_id');
    }

    public function pyqSub()
    {
        return $this->hasMany(PyqSubject::class, 'pyq_id');
    }

    
    
    
}
