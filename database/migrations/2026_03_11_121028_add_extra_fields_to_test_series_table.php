<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('test_series', function (Blueprint $table) {

            $table->integer('validity')->default(365)->after('price');
            $table->longText('overview')->nullable()->after('description');
            $table->json('key_features')->nullable()->after('overview');

        });
    }

    public function down()
    {
        Schema::table('test_series', function (Blueprint $table) {

            $table->dropColumn([
                'validity',
                'overview',
                'key_features'
            ]);

        });
    }
};