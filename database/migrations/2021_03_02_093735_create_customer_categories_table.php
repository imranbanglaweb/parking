<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('station_id');
            $table->unsignedSmallInteger('vehicle_type_id');
            $table->unsignedSmallInteger('space_limit')->default(0);
            $table->unsignedSmallInteger('used')->default(0);
            $table->unsignedSmallInteger('left')->default(0);
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
        Schema::dropIfExists('customer_categories');
    }
}
