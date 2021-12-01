<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnemyDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enemy_databases', function (Blueprint $table) {
            $table->id();
            $table->biginteger('quest_id');
            $table->biginteger('enemy_id');
            $table->integer('now_hit_point')->default(0);
            $table->integer('now_magical_point')->default(0);
            $table->integer('now_attack_point')->default(0);
            $table->integer('now_defense_point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enemy_databases');
    }
}
