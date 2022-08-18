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
            $table->string('short_title')->nullable();
            $table->date('event_date');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('place');
            $table->integer('limit_number')->nullable();
            $table->string('description')->nullable();
            $table->integer('expenses')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('number_of_user')->nullable();
            $table->integer('price1')->nullable();
            $table->integer('price2')->nullable();
            $table->integer('price3')->nullable();
            $table->integer('price4')->nullable();
            $table->integer('price5')->nullable();
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
