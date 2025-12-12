<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PercentageSystem extends Model
{
    protected $table = 'percentage_system';

    protected $fillable = [
        'from_percentage',
        'to_percentage',
        'division',
        'status'
    ];
}
