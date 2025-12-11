<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('student_test_attempts', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('test_id');

            $table->enum('status', ['in_progress', 'published', 'pending', 'under_review'])->default('in_progress');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Summary
            $table->integer('total_questions')->default(0);
            $table->integer('attempted_count')->default(0);
            $table->integer('not_attempted')->default(0);

            // Auto evaluated
            $table->integer('correct_count')->default(0);
            $table->integer('wrong_count')->default(0);
            
            // Total test marks set during creation
            $table->decimal('actual_marks', 10,2)->nullable();

            // Auto scoring fields
            $table->decimal('earned_positive_score', 10,2)->default(0);
            $table->decimal('earned_negative_score', 10,2)->default(0);

            $table->decimal('max_positive_score', 10,2)->default(0);
            $table->decimal('max_negative_score', 10,2)->default(0);

            $table->decimal('final_score', 10,2)->default(0);

            // Time
            $table->integer('time_taken')->nullable(); // seconds

            $table->timestamps();

            // $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_test_attempts');
    }
}
