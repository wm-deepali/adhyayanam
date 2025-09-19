<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog_and_articles';

    protected $fillable = [
        'user_id',
        'heading',
        'short_description',
        'description',
        'type',
        'image',
        'thumbnail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
