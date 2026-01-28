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
        'status',
    ];

    /* Optional helper */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            1 => 'Active',
            2 => 'Published',
            3 => 'Passive',
            default => 'Pending',
        };
    }
}
