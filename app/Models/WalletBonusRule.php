<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletBonusRule extends Model
{
    protected $fillable = ['wallet_setting_id', 'min_deposit', 'extra_bonus_value', 'bonus_type'];

    public function setting()
    {
        return $this->belongsTo(WalletSetting::class);
    }
}
