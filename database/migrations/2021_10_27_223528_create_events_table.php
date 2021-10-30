<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('short_title');
            $table->date('event_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('place');
            $table->integer('limit_number');
            $table->string('detail');
            $table->integer('expenses');
            $table->integer('amount');
            $table->integer('number_of_member');
            $table->integer('price1');
            $table->integer('price2');
            $table->integer('price3');
            $table->integer('price4');
            $table->integer('price5');
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
        Schema::dropIfExists('events');
    }
}
