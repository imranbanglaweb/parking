<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('author_id');
			$table->string('title', 191);
			$table->text('excerpt')->nullable();
			$table->text('body')->nullable();
			$table->string('image', 191)->nullable();
			$table->string('slug', 191)->unique();
			$table->text('meta_description')->nullable();
			$table->text('meta_keywords')->nullable();
			$table->enum('status', array('ACTIVE','INACTIVE'))->default('INACTIVE');
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
		Schema::drop('pages');
	}

}
