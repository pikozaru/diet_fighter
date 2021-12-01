<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreAndClearScoreAndClearPointToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('score')->default(0);
            $table->integer('clear_score')->default(0);
            $table->integer('clear_point')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('score');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('clear_score');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('clear_point');
        });
    }
}
