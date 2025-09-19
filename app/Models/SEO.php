<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    protected $table = 'seo';
    protected $fillable = ['page', 'title', 'description', 'keywords', 'canonical'];

    public function pageV()
    {
        return $this->belongsTo(Page::class);
    }
}
