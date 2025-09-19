<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PyqSubject extends Model
{
    use HasFactory;

    protected $fillable=[
        'pyq_id',
        'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function pyq()
    {
        return $this->belongsTo(PYQ::class, 'pyq_id');
    }
    
    
}
