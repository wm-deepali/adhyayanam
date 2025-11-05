<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolutionToQuestionDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('question_details', function (Blueprint $table) {
            $table->text('solution')->nullable()->after('answer_format');
        });
    }

    public function down()
    {
        Schema::table('question_details', function (Blueprint $table) {
            $table->dropColumn('solution');
        });
    }
}
