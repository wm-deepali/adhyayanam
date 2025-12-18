<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationCommission extends Model
{
    use HasFactory;

    protected $table = 'examination_commission';

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical_url',
        'image',
        'alt_tag',
        'status',
        'created_by'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'exam_com_id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
