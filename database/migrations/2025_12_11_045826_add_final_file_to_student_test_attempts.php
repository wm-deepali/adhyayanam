<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('student_test_attempts', function (Blueprint $table) {

            // Add final file
            $table->string('final_file')->nullable()->after('final_score');

            // Add assigned teacher
            $table->unsignedBigInteger('assigned_teacher_id')
                ->nullable()
                ->after('final_file');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('student_test_attempts', function (Blueprint $table) {

            // Drop foreign key first
            $table->dropForeign(['assigned_teacher_id']);

            // Drop columns
            $table->dropColumn('assigned_teacher_id');
            $table->dropColumn('final_file');
        });
    }
};
