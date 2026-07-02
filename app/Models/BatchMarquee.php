<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchMarquee extends Model
{
    protected $table = 'batch_marquees';

    protected $fillable = [
        'content',
        'status',
    ];
}