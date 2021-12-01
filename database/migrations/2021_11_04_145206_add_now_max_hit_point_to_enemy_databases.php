<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNowMaxHitPointToEnemyDatabases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enemy_databases', function (Blueprint $table) {
            $table->integer('now_max_hit_point')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enemy_databases', function (Blueprint $table) {
            $table->dropColumn('now_max_hit_point');
        });
    }
}
