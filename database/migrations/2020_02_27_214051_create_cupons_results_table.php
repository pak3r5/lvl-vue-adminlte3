<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuponsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('matchweek_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('code')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('matchweek_id')->references('id')->on('matchweeks');
        });

        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('participant_id')->unsigned();
            $table->bigInteger('match_id')->unsigned();
            $table->integer('local')->unsigned();
            $table->integer('visitant')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cupons');
        Schema::dropIfExists('results');
    }
}
