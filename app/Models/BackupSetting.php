<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupSetting extends Model
{
    protected $fillable = [
        'mode',
        'frequency',
        'run_time',
        'keep_last',
        'last_run_at',
    ];

    protected $casts = [
        'last_run_at' => 'datetime',
    ];

    /**
     * Har baar sirf ek hi settings row honi chahiye — ye helper wahi row deta hai,
     * agar exist nahi karti to default values ke saath bana deta hai.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'mode'      => 'manual',
                'frequency' => 'daily',
                'run_time'  => '02:00:00',
                'keep_last' => 7,
            ]
        );
    }
}