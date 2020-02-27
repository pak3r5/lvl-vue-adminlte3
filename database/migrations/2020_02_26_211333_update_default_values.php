<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitants', function (Blueprint $table) {
            $table->dropForeign('visitants_match_id_foreign');
            $table->dropColumn('match_id');
        });

        Schema::table('locals', function (Blueprint $table) {
            $table->dropForeign('locals_match_id_foreign');
            $table->dropColumn('match_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locals', function (Blueprint $table) {
            $table->integer('match_id');
            $table->foreign('match_id')->references('id')->on('matches');
        });

        Schema::table('visitants', function (Blueprint $table) {
            $table->integer('match_id');
            $table->foreign('match_id')->references('id')->on('matches');

        });
    }
}
