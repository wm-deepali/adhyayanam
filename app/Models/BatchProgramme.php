<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchProgramme extends Model
{
    use HasFactory;

    protected $table = 'batches_and_programme';

    // Define the fillable attributes
    protected $fillable = [
        'name',
        'duration',
        'start_date',
        'mrp',
        'discount',
        'offered_price',
        'batch_heading',
        'short_description',
        'batch_overview',
        'detail_content',
        'thumbnail_image',
        'banner_image',
        'youtube_url',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'image_alt_tag',
    ];
}
