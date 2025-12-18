<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'permissions',
        'created_by'
    ];

    protected $casts = [
        'permissions' => 'array', // auto JSON encode/decode
    ];

    /**
     * Role Group has many Users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_group_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
