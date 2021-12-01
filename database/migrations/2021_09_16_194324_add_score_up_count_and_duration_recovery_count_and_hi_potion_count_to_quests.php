<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreUpCountAndDurationRecoveryCountAndHiPotionCountToQuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->integer('score_up_count')->default(0);
            $table->integer('point_up_count')->default(0);
            $table->integer('hi_potion_count')->default(0);
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
            $table->dropColumn('score_up_count');
        });
        
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('point_up_count');
        });
        
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('hi_potion_count');
        });
    }
}
