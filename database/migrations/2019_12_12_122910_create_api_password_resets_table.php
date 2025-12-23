<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_password_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 191)->nullable();
            $table->string('username', 50)->index('apr_username_index');
            $table->string('token', 191);
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
        Schema::dropIfExists('api_password_resets');
    }
}
