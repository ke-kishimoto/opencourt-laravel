<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_level');
            $table->string('email')->nullable();
            $table->string('name');
            $table->string('tel')->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->integer('user_category_id')->nullable();
            $table->string('status');
            $table->string('description')->nullable();
            $table->string('line_id')->nullable();
            $table->string('line_access_token')->nullable();
            $table->string('line_refresh_token')->nullable();
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
