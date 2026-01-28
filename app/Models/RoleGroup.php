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
        'created_by',
        'approved_by',
        'status',
    ];

    protected $casts = [
        'permissions' => 'array', // auto JSON encode/decode
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Role Group has many Users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_group_id');
    }

    /**
     * Created by (Sub-admin / Admin)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Approved by (Admin only)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers (OPTIONAL BUT CLEAN)
    |--------------------------------------------------------------------------
    */

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPending()
    {
        return $this->status === 'pending_approval';
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }
}