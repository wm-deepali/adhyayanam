<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletSetting extends Model
{
    protected $fillable = [
        'welcome_bonus',
        'referral_bonus',
        'referee_bonus',
        'updated_by',
    ];

    public function bonusRules()
    {
        return $this->hasMany(WalletBonusRule::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}