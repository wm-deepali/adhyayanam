<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_details', function (Blueprint $table) {
            $table->decimal('positive_mark', 8, 2)->nullable()->after('question_id');
            $table->decimal('negative_mark', 8, 2)->nullable()->after('positive_mark');
        });
    }

    public function down(): void
    {
        Schema::table('test_details', function (Blueprint $table) {
            $table->dropColumn(['positive_mark', 'negative_mark']);
        });
    }
};
