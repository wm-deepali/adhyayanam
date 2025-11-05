<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('test_details', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_question_id')->nullable()->after('question_id');
        });
    }

    public function down(): void
    {
        Schema::table('test_details', function (Blueprint $table) {
                $table->dropColumn('parent_question_id');
        });
    }
};
