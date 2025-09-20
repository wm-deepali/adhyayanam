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
        Schema::table('study_material', function (Blueprint $table) {
            $table->unsignedBigInteger('commission_id')->nullable()->after('id');
            $table->unsignedBigInteger('sub_category_id')->nullable()->after('commission_id');
            $table->unsignedBigInteger('subject_id')->nullable()->after('sub_category_id');
            $table->unsignedBigInteger('chapter_id')->nullable()->after('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->dropColumn([
                'commission_id',
                'sub_category_id',
                'subject_id',
                'chapter_id',
            ]);
        });
    }
};
