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
        Schema::table('test_series_details', function (Blueprint $table) {

            // ✅ Store selected subjects (multi-select)
            $table->json('subject_ids')
                  ->nullable()
                  ->after('test_generated_by');

            // ✅ Store selected chapters (multi-select)
            $table->json('chapter_ids')
                  ->nullable()
                  ->after('subject_ids');

            // ✅ Store selected topics (multi-select)
            $table->json('topic_ids')
                  ->nullable()
                  ->after('chapter_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_series_details', function (Blueprint $table) {
            $table->dropColumn([
                'subject_ids',
                'chapter_ids',
                'topic_ids',
            ]);
        });
    }
};
