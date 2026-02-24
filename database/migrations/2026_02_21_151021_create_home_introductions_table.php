<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeIntroductionsTable extends Migration
{
    public function up()
    {
        Schema::create('home_introductions', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->text('description');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_introductions');
    }
}