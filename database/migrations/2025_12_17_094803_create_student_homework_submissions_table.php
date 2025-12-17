<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('student_homework_submissions', function (Blueprint $table) {
            $table->id();

            // ======================
            // RELATIONS
            // ======================
            $table->unsignedBigInteger('student_id'); // logged-in student
            $table->unsignedBigInteger('teacher_id')->nullable(); // assigned teacher
            $table->unsignedBigInteger('video_id');   // live class

            // ======================
            // STUDENT SUBMISSION
            // ======================
            $table->string('assignment_file');
            $table->timestamp('submitted_at')->nullable();

            // ======================
            // TEACHER REVIEW
            // ======================
            $table->text('teacher_remark')->nullable();
            $table->integer('marks')->nullable();
            $table->enum('status', ['submitted', 'checked', 'rejected'])->default('submitted');
            $table->timestamp('checked_at')->nullable();

            $table->timestamps();

            // One submission per student per live class
            $table->unique(['student_id', 'video_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_homework_submissions');
    }
};
