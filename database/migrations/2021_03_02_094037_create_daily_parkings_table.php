<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_parkings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('vehicle_type_id');
            $table->unsignedSmallInteger('station_id');
            $table->unsignedSmallInteger('token_number');
            $table->unsignedSmallInteger('tenant_id');
            $table->string('vehicle_number');
            $table->string('mobile_number')->nullable();
            $table->enum('payment_status',['Free','Paid'])->default('Free');
            $table->string('clock_in');
            $table->string('clock_out')->nullable();
            $table->string('total_time')->nullable();
            $table->float('payable_amount',10,3)->default(0);
            $table->float('paid_amount',10,3)->default(0);
            $table->boolean('status')->default(1)->comment('1=>Active, 0=>Inactive');
            $table->softDeletes();
            $table->unsignedInteger('added_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_parkings');
    }
}
