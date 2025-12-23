<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaIdToDailyParkings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_parkings', function (Blueprint $table) {
            $table->unsignedSmallInteger('area_id')->after('tenant_id');
            $table->unsignedSmallInteger('code_id')->after('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_parkings', function (Blueprint $table) {
            $table->dropColumn('area_id');
            $table->dropColumn('code_id');
        });
    }
}
