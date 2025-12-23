<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('table_name', 191);
			$table->string('column_name', 191);
			$table->integer('foreign_key')->unsigned();
			$table->string('locale', 191);
			$table->text('value');
			$table->timestamps();
			$table->unique(['table_name','column_name','foreign_key','locale'], 'translations_name_column_name_locale_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('translations');
	}

}
