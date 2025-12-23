<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity_logs', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('table_name', 200);
			$table->integer('key_id');
			$table->enum('operation', array('insert','update','delete'))->default('insert');
			$table->integer('operated_by');
			$table->dateTime('operated_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activity_logs');
	}

}
