<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletSetting extends Model
{
    protected $fillable = ['welcome_bonus', 'updated_by'];

    public function bonusRules()
    {
        return $this->hasMany(WalletBonusRule::class);
    }

    // App\Models\WalletSetting.php
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
