<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // e.g. "UPI", "Credit Card", "Net Banking" -- the actual instrument used
            $table->string('payment_mode')->nullable()->after('payment_status');
            // e.g. "CashFree" -- the gateway used, useful if you add another gateway later
            $table->string('payment_gateway')->default('CashFree')->after('payment_mode');
            // raw reason string from Cashfree (error_description / payment_message) for support team
            $table->string('payment_remark')->nullable()->after('payment_gateway');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('payment_status');
            $table->string('payment_gateway')->default('CashFree')->after('payment_mode');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'payment_gateway', 'payment_remark']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'payment_gateway']);
        });
    }
};