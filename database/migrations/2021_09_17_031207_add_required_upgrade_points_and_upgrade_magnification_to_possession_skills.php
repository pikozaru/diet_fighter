<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequiredUpgradePointsAndUpgradeMagnificationToPossessionSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('possession_skills', function (Blueprint $table) {
            $table->integer('required_upgrade_points')->default(0);
            $table->integer('upgrade_magnification')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('possession_skills', function (Blueprint $table) {
            $table->dropColumn('required_upgrade_points');
        });
        
        Schema::table('possession_skills', function (Blueprint $table) {
            $table->dropColumn('upgrade_magnification');
        });
    }
}
