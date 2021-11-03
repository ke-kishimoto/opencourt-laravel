<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id');
            $table->integer('member_id');
            $table->string('remark')->nullable();
            $table->integer('status');
            $table->integer('attendance');
            $table->integer('amount')->nullable();
            $table->string('amount_remark')->nullable();
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
        Schema::dropIfExists('event_members');
    }
}
