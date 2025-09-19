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
         Schema::table('feedback_testimonial', function (Blueprint $table) {
            $table->string('status')->default('0')->after('photo'); // Adjust the type and position of the new column as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_testimonial', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
