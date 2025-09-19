<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopUp extends Model
{
    use HasFactory;

    protected $table='pop_up';

    protected $fillable=[
        'pop_image',
        'link',
        'title'
    ];
}
