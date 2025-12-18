<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingExam extends Model
{
    use HasFactory;
    protected $table = "upcoming_exam";
    protected $fillable = [
        'commission_id',
        'examination_name',
        'advertisement_date',
        'form_distribution_date',
        'submission_last_date',
        'examination_date',
        'link',
        'pdf',
        'created_by'
    ];

    public function exam_commission()
    {
        return $this->belongsTo(ExaminationCommission::class,'commission_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
