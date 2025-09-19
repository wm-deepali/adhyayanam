<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    
    protected $table = 'contact_inquiries';
    protected $fillable = [
        'name',
        'email',
        'website',
        'message',
    ];
}
