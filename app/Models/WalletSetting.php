<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletSetting extends Model
{
    protected $fillable = ['welcome_bonus'];

    public function bonusRules()
    {
        return $this->hasMany(WalletBonusRule::class);
    }
}
