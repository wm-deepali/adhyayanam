<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table = 'pages';

    // Define which attributes are mass assignable
    protected $fillable = [
        'heading1',
        'heading2',
        'description1',
        'description2',
        'youtube_url',
        'image1',
        'image2',
        'status',
        'updated_by'
    ];
    public function seo()
    {
        return $this->hasOne(SEO::class);
    }
   
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
