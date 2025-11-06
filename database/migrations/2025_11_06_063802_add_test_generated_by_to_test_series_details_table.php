<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestGeneratedByToTestSeriesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('test_series_details', function (Blueprint $table) {
            $table->string('test_generated_by', 100)
                  ->nullable()
                  ->after('test_paper_type'); // place it after the paper type column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_series_details', function (Blueprint $table) {
            $table->dropColumn('test_generated_by');
        });
    }
}
