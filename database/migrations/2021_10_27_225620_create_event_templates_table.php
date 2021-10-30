<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('short_title');
            $table->string('place');
            $table->string('detail');
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
        Schema::dropIfExists('event_templates');
    }
}
