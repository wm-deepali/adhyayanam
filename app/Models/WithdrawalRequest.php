<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $table = 'withdrawal_requests';

    protected $fillable = [
        'teacher_id',
        'amount',
        'status',
        'payment_date',
        'reference_id',
        'remarks',
        'screenshot',
        'processed_by',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * A withdrawal request belongs to a teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * The admin who processed this request
     */
    public function processedBy()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }

    /**
     * Helper methods for admin actions
     */

    public function approve($adminId, $paymentDate = null, $referenceId = null, $remarks = null, $screenshot = null)
    {
        $this->update([
            'status'        => 'approved',
            'processed_by'  => $adminId,
            'payment_date'  => $paymentDate,
            'reference_id'  => $referenceId,
            'remarks'       => $remarks,
            'screenshot'    => $screenshot,
        ]);

        // Optional: Update teacher wallet and transactions here
    }

    public function reject($adminId, $remarks = null)
    {
        $this->update([
            'status'        => 'rejected',
            'processed_by'  => $adminId,
            'remarks'       => $remarks,
        ]);
    }
}
