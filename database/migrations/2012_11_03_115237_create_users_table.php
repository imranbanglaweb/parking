<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_superuser')->default(0);
			$table->bigInteger('role_id')->unsigned()->nullable()->index('users_role_id_foreign');
			$table->string('name', 191);
			$table->enum('user_type', ['normal_user', 'super_user'])->default('normal_user');
			$table->string('email', 191)->unique();
			$table->string('user_name', 100)->unique();
			$table->string('cell_phone', 15);
			$table->string('avatar', 191)->nullable()->default('users/default.png');
			$table->boolean('status')->default(1)->comment('1=>Active, 0=>Inactive, 99=>Deleted');
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->text('settings')->nullable();
                        $table->integer('created_by')->unsigned()->nullable();
                        $table->integer('updated_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
