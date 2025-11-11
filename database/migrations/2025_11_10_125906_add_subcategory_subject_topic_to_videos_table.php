<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->nullable()->after('chapter_id');
            $table->unsignedBigInteger('subject_id')->nullable()->after('sub_category_id');
            $table->unsignedBigInteger('topic_id')->nullable()->after('subject_id');

            // If you want, you can also add foreign keys
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('topic_id')->references('id')->on('course_topics')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['topic_id']);

            $table->dropColumn(['sub_category_id', 'subject_id', 'topic_id']);
        });
    }
};
