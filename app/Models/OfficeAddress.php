<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeAddress extends Model
{
    protected $fillable = [
        'office_type',
        'address',
        'phone',
        'email',
        'map_link',
        'sort_order',
        'status'
    ];
}