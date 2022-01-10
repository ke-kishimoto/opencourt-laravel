<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventUserCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user_companions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_user_id');
            $table->integer('category_id');
            $table->integer('gender');
            $table->string('name');
            $table->integer('status');
            $table->integer('attendance');
            $table->integer('amount');
            $table->string('amount_remark');
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
        Schema::dropIfExists('event_user_companions');
    }
}
