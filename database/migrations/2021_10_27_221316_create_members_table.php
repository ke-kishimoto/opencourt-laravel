<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_level');
            $table->string('email')->nullable();
            $table->string('name');
            $table->string('tel')->nullable();
            $table->string('password')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('members');
    }
}
