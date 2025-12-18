<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // migration file
    public function up()
    {
        Schema::table('examination_commission', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('status');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examination_commission', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
    }
};
