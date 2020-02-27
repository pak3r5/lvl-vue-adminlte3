<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMatchweekValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locals', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('visitants', function (Blueprint $table) {
            $table->dropColumn('uuid');
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
            $table->uuid('uuid')->unique()->index();
        });

        Schema::table('visitants', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->index();
        });
    }
}
