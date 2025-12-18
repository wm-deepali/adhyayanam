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
        Schema::table('batches_and_programme', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('image_alt_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches_and_programme', function (Blueprint $table) {
            $table->dropColumn(['created_by']);
        });
    }
};
