<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableToActionHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_histories', function (Blueprint $table) {
            $table->biginteger('quest_id')->nullable()->change();
        });
        
        Schema::table('action_histories', function (Blueprint $table) {
            $table->biginteger('enemy_id')->nullable()->change();
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
            $table->biginteger('quest_id')->change();
        });
        
        Schema::table('action_histories', function (Blueprint $table) {
            $table->biginteger('enemy_id')->change();
        });
    }
}
