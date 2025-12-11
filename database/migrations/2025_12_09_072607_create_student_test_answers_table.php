<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('student_test_answers', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('attempt_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('parent_question_id')->nullable();

            // Stores MCQ selected key (A/B/C/D/E)
            $table->string('answer_key')->nullable();

            // Stores actual answer text (or option text)
            $table->longText('answer_text')->nullable();

            // File based responses
            $table->string('answer_file')->nullable();

            // For story-based children stored as JSON
            // children = [
            //   { "child_id":1, "answer_key":"B", "answer":"Text or option", "file":"abc.pdf" }
            // ]
            $table->json('child_responses')->nullable();

            // Marks obtained for this question
            // For subjective → null until teacher evaluates
            $table->decimal('obtained_marks', 10, 2)->nullable();
            $table->decimal('positive_mark', 8, 2)->nullable();
            $table->decimal('negative_mark', 8, 2)->nullable();
            
            // Whether this question needs teacher evaluation
            $table->boolean('requires_manual_check')->default(false);

            $table->enum('attempt_status', ['attempted', 'not_attempted'])->default('not_attempted');
            $table->enum('evaluation_status', ['correct', 'wrong', 'partial', 'pending', 'not_evaluated'])->nullable();

            // When answer was submitted
            $table->timestamp('answered_at')->nullable();


            $table->timestamps();

            $table->foreign('attempt_id')
                ->references('id')->on('student_test_attempts')
                ->onDelete('cascade');

            // NOTE:
            // question_id can map to Questions OR QuestionDetail,
            // so we keep it unrestricted — no FK constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_test_answers');
    }
}
