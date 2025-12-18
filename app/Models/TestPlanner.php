<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPlanner extends Model
{
    use HasFactory;
    protected $table = 'test_planner';
    protected $fillable = [
        'title',
        'start_date',
        'short_description',
        'detail_content',
        'pdf',
        'status',
        'created_at'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
