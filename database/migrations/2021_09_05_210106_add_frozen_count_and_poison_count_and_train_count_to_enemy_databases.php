<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrozenCountAndPoisonCountAndTrainCountToEnemyDatabases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enemy_databases', function (Blueprint $table) {
            $table->integer('frozen_count')->default(0);
            $table->integer('poison_count')->default(0);
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
            $table->dropColumn('frozen_count');
        });
        
        Schema::table('enemy_databases', function (Blueprint $table) {
            $table->dropColumn('poison_count');
        });
    }
}
