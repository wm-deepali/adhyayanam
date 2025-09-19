<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSeriesDetail extends Model
{
    use HasFactory;
    protected $table ='test_series_details';
    protected $fillable = [
        'test_series_id',
        'type',
        'type_name',
        'test_id',
        'test_paper_type',
        // 'is_previous',
    ];

   
    public function test()
    {
        return $this->belongsTo('App\Models\Test');
    }
}
