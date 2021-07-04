<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->biginteger('user_id');
            $table->integer('level');
            $table->integer('action_point');
            $table->integer('max_hit_point');
            $table->integer('max_magical_point');
            $table->integer('hit_point');
            $table->integer('magical_point');
            $table->integer('attack_point');
            $table->integer('defense_point');
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->decimal('weight_before');
            $table->decimal('weight_after');
            $table->decimal('body_fat_percentage_before');
            $table->decimal('body_fat_percentage_after');
            $table->integer('score');
            $table->integer('mastering_point');
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
        Schema::dropIfExists('quests');
    }
}
