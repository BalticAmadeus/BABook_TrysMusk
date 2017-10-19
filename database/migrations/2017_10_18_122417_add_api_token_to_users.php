<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiTokenToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('api_token', 60)->nullable()->after('remember_token');
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('api_token');
        });
    }
}
