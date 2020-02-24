<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchweeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchweeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->bigInteger('league_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('league_id')->references('id')->on('leagues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchweeks');
    }
}
