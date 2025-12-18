<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $table="topic";
    protected $fillable=[
        'name',
        'description',
        'created_by'
    ];

    public function currentAffair()
    {
        return $this->hasMany(CurrentAffair::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
