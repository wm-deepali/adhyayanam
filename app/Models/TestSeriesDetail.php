<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSeriesDetail extends Model
{
    use HasFactory;

    protected $table = 'test_series_details';

    /**
     * -------------------------------------------------
     * Mass Assignable Fields
     * -------------------------------------------------
     */
    protected $fillable = [
        'test_series_id',
        'type',
        'type_name',
        'test_id',
        'test_paper_type',
        'test_generated_by',

        // ✅ NEW CONTEXT FIELDS
        'subject_ids',
        'chapter_ids',
        'topic_ids',
    ];

    /**
     * -------------------------------------------------
     * Cast JSON fields automatically
     * -------------------------------------------------
     */
    protected $casts = [
        'subject_ids' => 'array',
        'chapter_ids' => 'array',
        'topic_ids'   => 'array',
    ];

    /**
     * -------------------------------------------------
     * Relationships
     * -------------------------------------------------
     */

    public function testSeries()
    {
        return $this->belongsTo(TestSeries::class, 'test_series_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
