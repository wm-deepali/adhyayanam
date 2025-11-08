<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->string('based_on')->nullable()->after('material_type');
        });
    }

    public function down()
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->dropColumn('based_on');
        });
    }
};
