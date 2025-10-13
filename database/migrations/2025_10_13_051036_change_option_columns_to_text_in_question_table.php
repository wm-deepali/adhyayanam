<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOptionColumnsToTextInQuestionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('question', function (Blueprint $table) {
            $table->text('option_a')->change();
            $table->text('option_b')->change();
            $table->text('option_c')->change();
            $table->text('option_d')->change();
            $table->text('option_e')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question', function (Blueprint $table) {
            $table->string('option_a', 255)->change();
            $table->string('option_b', 255)->change();
            $table->string('option_c', 255)->change();
            $table->string('option_d', 255)->change();
            $table->string('option_e', 255)->nullable()->change();
        });
    }
}
