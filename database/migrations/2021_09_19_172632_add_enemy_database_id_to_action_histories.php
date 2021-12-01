<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnemyDatabaseIdToActionHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_histories', function (Blueprint $table) {
            $table->biginteger('enemy_database_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_history', function (Blueprint $table) {
            $table->dropColumn('enemy_database_id');
        });
    }
}
