<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::create([
            'name' => 'ヒール',
            'description' => '自身のHPを回復する',
            'required_action_points' => '5',
            'consumed_magic_points' => '5',
            'required_points' => '100',
            'first_magnification' => '0'
        ]);
        
        Skill::create([
            'name' => 'ファイア',
            'description' => '敵に大ダメージを与える',
            'required_action_points' => '5',
            'consumed_magic_points' => '7',
            'required_points' => '500',
            'first_magnification' => '1.2'
        ]);
        
        
        Skill::create([
            'name' => 'アイス',
            'description' =>'敵に大ダメージを与え、数ターン凍結させる',
            'required_action_points' => '5',
            'consumed_magic_points' => '10',
            'required_points' => '1500',
            'first_magnification' => '1.2'
        ]);
        
        
        Skill::create([
            'name' => 'ポイズン',
            'description' => '敵に少しずつダメージを与える',
            'required_action_points' => '5',
            'consumed_magic_points' => '7',
            'required_points' => '1500',
            'first_magnification' => '0.3'
        ]);
        
        
        Skill::create([
            'name' => '鍛える',
            'description' => '数ターン攻撃力が上昇',
            'required_action_points' => '8',
            'consumed_magic_points' => '0',
            'required_points' => '2000',
            'first_magnification' => '1.1'
        ]);
        
        Skill::create([
            'name' => '貫通攻撃',
            'description' => '一定の確率で敵の防御力を0にして攻撃',
            'required_action_points' => '10',
            'consumed_magic_points' => '0',
            'required_points' => '4000'
        ]);
    }
}
