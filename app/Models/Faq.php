<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'faq';
    protected $fillable = [
        'question',
        'answer',
        'type',
        'created_by',
        'show_on_home'
    ];

    protected $cast =
    [
        'show_on_home' => 'boolean'
    ];

     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
