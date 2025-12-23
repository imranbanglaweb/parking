<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocUnionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loc_unions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->mediumInteger('loc_division_id')->unsigned();
			$table->mediumInteger('loc_district_id')->unsigned();
			$table->integer('loc_upazila_id')->unsigned();
			$table->char('division_bbs_code', 4)->nullable();
			$table->char('district_bbs_code', 4)->nullable();
			$table->char('upazila_bbs_code', 4)->nullable();
			$table->string('title_en');
			$table->string('title');
			$table->char('bbs_code', 4)->nullable();
			$table->boolean('status')->default(1);
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
		Schema::drop('loc_unions');
	}

}
