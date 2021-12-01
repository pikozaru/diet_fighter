<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnToActionHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_histories', function (Blueprint $table) {
            $table->dropColumn('player_action');
        });
        
        Schema::table('action_histories', function (Blueprint $table) {
            $table->dropColumn('enemy_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_histories', function (Blueprint $table) {
            $table->string('player_action')->default(0);
            $table->string('enemy_action')->default(0);
        });
    }
}
