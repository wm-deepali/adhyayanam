<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_test_attempts', function (Blueprint $table) {
            // Stores the shuffled question_id sequence generated at the
            // start of THIS attempt, so resuming an in-progress attempt
            // (page refresh, navigating away and back, etc.) keeps the
            // same order instead of re-shuffling mid-test. A brand new
            // attempt (retake) always generates and stores a fresh shuffle.
            $table->longText('question_order')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('student_test_attempts', function (Blueprint $table) {
            $table->dropColumn('question_order');
        });
    }
};