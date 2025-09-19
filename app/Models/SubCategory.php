<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_category';

    protected $fillable = [
        'category_id',
        'name',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical_url',
        'image',
        'alt_tag',
        'status',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'sub_category_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
