<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTable extends Migration
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
            $table->bigInteger('matchweek_id')->unsigned();
            $table->bigInteger('local_id')->unsigned();
            $table->integer('local')->unsigned();
            $table->bigInteger('visitant_id')->unsigned();
            $table->integer('visitant')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('matchweek_id')->references('id')->on('matchweeks');
            $table->foreign('local_id')->references('id')->on('teams');
            $table->foreign('visitant_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test');
    }
}
