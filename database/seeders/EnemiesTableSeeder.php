<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enemies;

class EnemiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enemies::create([
            'name' => 'スライム',
            'max_hit_point' => '40',
            'max_magical_point' => '0',
            'hit_point' => '40',
            'magical_point' => '0',
            'attack_point' => '7.6',
            'defense_point' => '2',
            'score' => '30'
        ]);
        
        Enemies::create([
            'name' => '赤スライム',
            'max_hit_point' => '50',
            'max_magical_point' => '0',
            'hit_point' => '50',
            'magical_point' => '0',
            'attack_point' => '7.8',
            'defense_point' => '5',
            'score' => '50'
        ]);
        
        Enemies::create([
            'name' => 'ゾンビ',
            'max_hit_point' => '60',
            'max_magical_point' => '0',
            'hit_point' => '60',
            'magical_point' => '0',
            'attack_point' => '8',
            'defense_point' => '10',
            'score' => '70'
        ]);
        
        Enemies::create([
            'name' => '動く花',
            'max_hit_point' => '65',
            'max_magical_point' => '0',
            'hit_point' => '65',
            'magical_point' => '0',
            'attack_point' => '8.2',
            'defense_point' => '7',
            'score' => '80'
        ]);
        
        Enemies::create([
            'name' => 'スケルトン',
            'max_hit_point' => '70',
            'max_magical_point' => '0',
            'hit_point' => '70',
            'magical_point' => '0',
            'attack_point' => '8',
            'defense_point' => '10',
            'score' => '75'
        ]);
        
        Enemies::create([
            'name' => '銀スライム',
            'max_hit_point' => '6',
            'max_magical_point' => '0',
            'hit_point' => '6',
            'magical_point' => '0',
            'attack_point' => '7.8',
            'defense_point' => '500',
            'score' => '500'
        ]);
        
        Enemies::create([
            'name' => '金スライム',
            'max_hit_point' => '10',
            'max_magical_point' => '0',
            'hit_point' => '10',
            'magical_point' => '0',
            'attack_point' => '7.8',
            'defense_point' => '1000',
            'score' => '5000'
        ]);
        
        Enemies::create([
            'name' => '魂喰',
            'max_hit_point' => '10',
            'max_magical_point' => '0',
            'hit_point' => '50',
            'magical_point' => '0',
            'attack_point' => '15',
            'defense_point' => '20',
            'score' => '60'
        ]);
        
        Enemies::create([
            'name' => '地獄鳥',
            'max_hit_point' => '60',
            'max_magical_point' => '0',
            'hit_point' => '60',
            'magical_point' => '0',
            'attack_point' => '8.3',
            'defense_point' => '8',
            'score' => '100'
        ]);
        
        Enemies::create([
            'name' => '魔法使い',
            'max_hit_point' => '50',
            'max_magical_point' => '0',
            'hit_point' => '50',
            'magical_point' => '0',
            'attack_point' => '7.9',
            'defense_point' => '5',
            'score' => '90'
        ]);
        
        Enemies::create([
            'name' => '動く鎧',
            'max_hit_point' => '100',
            'max_magical_point' => '0',
            'hit_point' => '100',
            'magical_point' => '0',
            'attack_point' => '8',
            'defense_point' => '15',
            'score' => '110'
        ]);
        
        Enemies::create([
            'name' => 'フォックス',
            'max_hit_point' => '70',
            'max_magical_point' => '0',
            'hit_point' => '70',
            'magical_point' => '0',
            'attack_point' => '8.3',
            'defense_point' => '8',
            'score' => '95'
        ]);
        
        Enemies::create([
            'name' => 'レッドドラゴン',
            'max_hit_point' => '700',
            'max_magical_point' => '0',
            'hit_point' => '700',
            'magical_point' => '0',
            'attack_point' => '34',
            'defense_point' => '10',
            'score' => '4000'
        ]);
        
        Enemies::create([
            'name' => 'ブルードラゴン',
            'max_hit_point' => '1300',
            'max_magical_point' => '0',
            'hit_point' => '1300',
            'magical_point' => '0',
            'attack_point' => '66',
            'defense_point' => '20',
            'score' => '4500'
        ]);
        
        Enemies::create([
            'name' => 'ゴールドドラゴン',
            'max_hit_point' => '2000',
            'max_magical_point' => '0',
            'hit_point' => '2000',
            'magical_point' => '0',
            'attack_point' => '88',
            'defense_point' => '30',
            'score' => '70000'
        ]);
        
        Enemies::create([
            'name' => 'ダークドラゴン',
            'max_hit_point' => '3000',
            'max_magical_point' => '0',
            'hit_point' => '3000',
            'magical_point' => '0',
            'attack_point' => '125',
            'defense_point' => '40',
            'score' => '1000000'
        ]);
    }
}
