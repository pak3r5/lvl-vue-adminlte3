<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatetimesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matchweeks', function (Blueprint $table) {
            $table->dropColumn(['start','end']);
        });

        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('matchweeks', function (Blueprint $table) {
            $table->dateTime('start');
            $table->dateTime('end');
        });

        Schema::create('matches', function (Blueprint $table) {
            $table->dateTime('start');
        });
    }
}
