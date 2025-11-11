<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course', function (Blueprint $table) {
            // JSON columns for multiple selection
            $table->json('subject_id')->nullable()->after('sub_category_id');
            $table->json('chapter_id')->nullable()->after('subject_id');
            $table->json('topic_id')->nullable()->after('chapter_id');

            // Single string column for course type (based_on)
            $table->string('based_on')->nullable()->after('topic_id');
        });
    }

    public function down(): void
    {
        Schema::table('course', function (Blueprint $table) {
            $table->dropColumn(['subject_id', 'chapter_id', 'topic_id', 'based_on']);
        });
    }
};
