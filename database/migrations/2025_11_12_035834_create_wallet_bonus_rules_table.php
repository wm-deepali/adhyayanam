<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_bonus_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_setting_id')->constrained('wallet_settings')->onDelete('cascade');
            $table->decimal('min_deposit', 10, 2);
            $table->decimal('extra_bonus_value', 10, 2);
            $table->enum('bonus_type', ['percentage', 'fixed']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_bonus_rules');
    }
};
