<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->dateTime('start');
            $table->bigInteger('matchweek_id')->unsigned();
            $table->bigInteger('matchtable_id')->unsigned();
            $table->string('matchtable_type');
            $table->integer('result');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('matchweek_id')->references('id')->on('matchweeks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
