<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeQuestItemsTableColumnItemId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_items', function (Blueprint $table) {
            $table->renameColumn('item_id','possession_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_items', function (Blueprint $table) {
            $table->renameColumn('possession_item_id','item_id');
        });
    }
}
