<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentAffair extends Model
{
    use HasFactory;

    protected $table = 'current_affairs';

    protected $fillable = [
        'topic_id',
        'title',
        'short_description',
        'details',
        'publishing_date',
        'thumbnail_image',
        'banner_image',
        'pdf_file',
        'image_alt_tag',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    // Relationship with Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
