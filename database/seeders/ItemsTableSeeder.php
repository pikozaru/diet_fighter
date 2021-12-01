<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
           'name' => '回復薬',
           'description' => 'HPを50回復'
        ]);
        
        Item::create([
            'name' => 'ポーション',
            'description' => 'MPを50回復'
        ]);
        
        Item::create([
            'name' => 'スコアUP',
            'description' => '5ターンの間、スコアUP'
        ]);
        
        Item::create([
            'name' => 'ポイントUP',
            'description' => '10ターンの間、ポイントUP'
        ]);
        
        Item::create([
            'name' => 'ハイポーション',
            'description' => '5ターンの間、消費MP0'
        ]);
    }
}
