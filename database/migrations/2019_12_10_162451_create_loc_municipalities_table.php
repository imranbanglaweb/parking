<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocMunicipalitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loc_municipalities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->mediumInteger('loc_division_id')->unsigned();
			$table->mediumInteger('loc_district_id')->unsigned();
			$table->integer('loc_upazila_id')->unsigned()->nullable();
			$table->string('geo_code', 10);
			$table->string('title_en', 100);
			$table->string('title', 300);
			$table->string('municipality_type', 300);
			$table->integer('created_by')->unsigned()->nullable();
			$table->integer('updated_by')->unsigned()->nullable();
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
		Schema::drop('loc_municipalities');
	}

}
