<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_numbers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('station_id');
            $table->unsignedSmallInteger('tenant_id');
            $table->unsignedSmallInteger('vehicle_type_id');
            $table->unsignedSmallInteger('area_id');
            $table->unsignedSmallInteger('code_id');
            $table->string('vehicle_number',100)->index();
            $table->string('mobile_number',100)->index();
            $table->string('parking_number',100)->index();
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
        Schema::dropIfExists('car_numbers');
    }
}
