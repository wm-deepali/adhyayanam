<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeIntroHighlightsTable extends Migration
{
    public function up()
    {
        Schema::create('home_intro_highlights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_introduction_id');
            $table->string('text');
            $table->timestamps();

            $table->foreign('home_introduction_id')
                  ->references('id')
                  ->on('home_introductions')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_intro_highlights');
    }
}