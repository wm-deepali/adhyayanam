<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'log_activity';
    
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id', 'user_name','updated_by','updated_by_id'
    ];
}
