<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;

use App\Notifications\TeacherResetPasswordNotification;

class Teacher extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // Personal Profile
        'full_name',
        'email',
        'mobile_number',
        'whatsapp_number',
        'gender',
        'dob',
        'highest_qualification',
        'total_experience',
        'full_address',
        'country',
        'state',
        'city',
        'pin_code',
        'allow_languages',
        'password',

        // Question Type Permissions
        'allow_mcq',
        'pay_per_mcq',
        'allow_subjective',
        'pay_per_subjective',
        'allow_story',
        'pay_per_story',

        // Bank Details
        'upi_id',
        'account_name',
        'account_number',
        'bank_name',
        'bank_branch',
        'ifsc_code',
        'swift_code',
        'cancelled_cheque',
        'qr_code',

        // Documents
        'pan_number',
        'pan_file',
        'aadhar_number',
        'aadhar_front',
        'aadhar_back',
        'profile_picture',
        'education_docs',
        'cv',

        // Teacher Stats
        'wallet_balance',

        // Status
        'status',
        'can_conduct_live_classes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'allow_languages' => 'array',
        'allow_mcq' => 'boolean',
        'allow_subjective' => 'boolean',
        'allow_story' => 'boolean',
        'status' => 'boolean',
        'pay_per_mcq' => 'decimal:2',
        'pay_per_subjective' => 'decimal:2',
        'pay_per_story' => 'decimal:2',
        'wallet_balance' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'pending' => 'decimal:2',
        'dob' => 'datetime',
        'can_conduct_live_classes' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    // Append dynamic attributes
    protected $appends = ['total_questions_count', 'total_paid_amount', 'pending_amount'];

    // Accessor for total questions
    public function getTotalQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }

    // Accessor for total paid (sum of all credit transactions)
    public function getTotalPaidAmountAttribute()
    {
        return $this->transactions()->where('type', 'credit')->sum('amount');
    }

    // Accessor for pending amount (sum of all debit transactions)
    public function getPendingAmountAttribute()
    {
        return $this->transactions()->where('type', 'debit')->sum('amount');
    }
    /**
     * Optional: Accessors to get formatted values
     */
    public function getFullNameAttribute($value)
    {
        return ucwords($value);
    }

    // 🔹 Teacher has many exam mappings
    public function examMappings()
    {
        return $this->hasMany(TeacherExamMapping::class);
    }

    // inside class Teacher extends Authenticatable

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TeacherResetPasswordNotification($token));
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'added_by_id')
            ->where('added_by_type', 'teacher');
    }

}
