<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTablesAndRenameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*Schema::table('locals', function (Blueprint $table) {
            $table->dropForeign(['match_id']);
            $table->dropForeign(['team_id']);
        });*/
        Schema::dropIfExists('locals');
        /*Schema::table('visitants', function (Blueprint $table) {
            $table->dropForeign(['match_id']);
            $table->dropForeign(['team_id']);
        });*/
        Schema::dropIfExists('visitants');
        Schema::table('results', function (Blueprint $table) {
            // $table->dropForeign('matches_result_id_foreign');
            //$table->dropForeign(['match_id']);
        });
        Schema::dropIfExists('results');
        Schema::table('matches', function (Blueprint $table) {
           // $table->dropForeign('matches_result_id_foreign');
            //$table->dropForeign(['matchweek_id']);
            //$table->dropForeign(['match_id']);
        });
        Schema::dropIfExists('matches');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('team_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('team_id')->references('id')->on('teams');
        });

        Schema::create('visitants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->bigInteger('team_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('team_id')->references('id')->on('teams');
        });

        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->index();
            $table->string('name');
            $table->bigInteger('matchweek_id')->unsigned(); //matchweek_uuid
            $table->bigInteger('matchtable_id')->unsigned();
            $table->string('matchtable_type');
            $table->integer('result');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('matchweek_id')->references('id')->on('matchweeks');
        });
    }
}
