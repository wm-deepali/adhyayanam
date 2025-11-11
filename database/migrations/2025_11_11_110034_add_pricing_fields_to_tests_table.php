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
        Schema::table('tests', function (Blueprint $table) {
            $table->decimal('mrp', 10, 2)->nullable()->after('test_paper_type');
            $table->decimal('discount', 10, 2)->nullable()->after('mrp');
            $table->decimal('offer_price', 10, 2)->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['mrp', 'discount', 'offer_price']);
        });
    }
};
