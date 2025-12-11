<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_test_answers', function (Blueprint $table) {

            // Teacher evaluation
            $table->text('teacher_remarks')->nullable()->after('obtained_marks');
            $table->string('teacher_file')->nullable()->after('teacher_remarks');

            // Admin evaluation / override
            $table->text('admin_remarks')->nullable()->after('teacher_file');
            $table->string('admin_file')->nullable()->after('admin_remarks');
        });
    }

    public function down()
    {
        Schema::table('student_test_answers', function (Blueprint $table) {
            $table->dropColumn([
                'teacher_remarks',
                'teacher_file',
                'admin_remarks',
                'admin_file'
            ]);
        });
    }
};
