<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wallet_settings', function (Blueprint $table) {
            $table->decimal('referral_bonus', 10, 2)->default(0)->after('welcome_bonus');
            $table->decimal('referee_bonus', 10, 2)->default(0)->after('referral_bonus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_settings', function (Blueprint $table) {
            $table->dropColumn(['referral_bonus', 'referee_bonus']);
        });
    }
};