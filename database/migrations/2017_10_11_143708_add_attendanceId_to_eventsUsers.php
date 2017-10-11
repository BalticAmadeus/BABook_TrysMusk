<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttendanceIdToEventsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventsUsers', function($table) {
            $table->increments('attendanceId')->before('userId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventsUsers', function($table) {
            $table->dropColumn('attendanceId');
        });
    }
}
