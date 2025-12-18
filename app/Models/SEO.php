<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    protected $table = 'seo';
    protected $fillable = ['page', 'title', 'description', 'keywords', 'canonical', 'created_by'];

    public function pageV()
    {
        return $this->belongsTo(Page::class);
    }

     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
