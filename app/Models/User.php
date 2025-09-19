<?php

namespace App\Models;

use App\Models\Presenters\UserPresenter;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use HasHashedMediaTrait;
    use UserPresenter;

    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method',
        'password_confirmation',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
        'email_verified_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'mobile',
        'password',
        'type',
        'is_save_activity',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class,'student_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'student_id');
    }

    public function courseOrder()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Course');
    }

    public function courseOrderAttempt()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Course')->where('attempt_status', 'completed');
    }

    public function courseOrderPending()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Course')->where('attempt_status', 'pending');
    }

    public function testSeriesOrder()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Test Series');
    }

    public function testSeriesOrderAttempt()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Test Series')->where('attempt_status', 'completed');
    }
    
    public function testSeriesOrderPending()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Test Series')->where('attempt_status', 'pending');
    }


    public function studyMaterialOrder()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Study Material');
    }

    public function studyMaterialOrderAttempt()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Study Material')->where('attempt_status', 'completed');
    }
    
    public function studyMaterialOrderPending()
    {
        return $this->hasMany(Order::class,'student_id')->where('order_type', 'Study Material')->where('attempt_status', 'pending');
    }

}
