<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventsUsers', function (Blueprint $table) {
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->integer('eventId')->unsigned();
            $table->foreign('eventId')->references('id')->on('events');
            $table->integer('status')->unsigned();
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
        Schema::dropIfExists('eventsUsers');
    }
}
