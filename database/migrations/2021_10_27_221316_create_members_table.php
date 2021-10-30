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
            $table->string('email');
            $table->string('name');
            $table->string('tel');
            $table->string('password');
            $table->integer('gender');
            $table->integer('category_id');
            $table->string('remark');
            $table->string('line_id');
            $table->string('line_access_token');
            $table->string('line_refresh_token');
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
