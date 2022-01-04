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
            $table->double('action_point');
            $table->double('max_hit_point');
            $table->double('max_magical_point');
            $table->double('hit_point');
            $table->double('magical_point');
            $table->double('attack_point');
            $table->double('defense_point');
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->decimal('weight_before');
            $table->decimal('weight_after');
            $table->decimal('body_fat_percentage_before');
            $table->decimal('body_fat_percentage_after');
            $table->double('score');
            $table->double('mastering_point');
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
