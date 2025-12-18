<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {

            // ✅ Permission: can evaluate student test papers
            $table->boolean('can_check_tests')
                  ->default(0)
                  ->comment('Whether teacher can evaluate student test papers')
                  ->after('can_conduct_live_classes');

            // ✅ Who created this teacher record
            $table->unsignedBigInteger('created_by')
                  ->nullable()
                  ->after('status');

        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['can_check_tests', 'created_by']);
        });
    }
};
