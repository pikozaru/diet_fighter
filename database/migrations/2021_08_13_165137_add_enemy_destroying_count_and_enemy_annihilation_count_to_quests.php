<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnemyDestroyingCountAndEnemyAnnihilationCountToQuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->integer('enemy_destorying_count')->default(0);
            $table->integer('enemy_annihilation_count')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('enemy_destorying_count');
        });
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('enemy_annihilation_count');
        });
    }
}
