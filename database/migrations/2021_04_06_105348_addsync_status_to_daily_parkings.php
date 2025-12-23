<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsyncStatusToDailyParkings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_parkings', function (Blueprint $table) {
             $table->boolean('sync_status')->default(0)->comment('1=>synccompleted, 0=>notsync');
             $table->unsignedInteger('station_parking_id')->after('tenant_id')->nullable();
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
            $table->dropColumn('sync_status');
            $table->dropColumn('station_parking_id');
        });

    }
}
