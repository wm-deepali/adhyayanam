<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedTestimonial extends Model
{
    use HasFactory;
    protected $table = 'feedback_testimonial';

    protected $fillable = [
        'type',
        'username',
        'email',
        'number',
        'message',
        'photo',
        'is_approved',
    ];
}
