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
        Schema::table('study_material', function (Blueprint $table) {
            $table->string('material_type')->nullable()->comment('subject_based, chapter_based, topic_based');
             $table->boolean('is_pdf_downloadable')->default(false)->after('pdf');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->dropColumn([
                'material_type',
                'is_pdf_downloadable'
            ]);
        });
    }
};
