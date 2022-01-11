<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'つかさ',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'22547830',
            'email' => 'todo@todo',
            'rank' => '188'
        ]);
        
        User::create([
            'name' => 'yuuya',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'21547830',
            'email' => 'aa@aa',
            'rank' => '188'
        ]);
        
        User::create([
            'name' => 'ラン',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'21437830',
            'email' => 'bb@bb',
            'rank' => '187'
        ]);
        
        User::create([
            'name' => 'Take',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'21227830',
            'email' => 'cc@cc',
            'rank' => '185'
        ]);
        
        User::create([
            'name' => 'NAOKI',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'21223830',
            'email' => 'dd@dd',
            'rank' => '182'
        ]);
        
        User::create([
            'name' => 'おおさわ',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'21220200',
            'email' => 'ee@ee',
            'rank' => '179'
        ]);
        
        User::create([
            'name' => 'major',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'20947830',
            'email' => 'ff@ff',
            'rank' => '178'
        ]);
        
        User::create([
            'name' => 'ipple',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'20547830',
            'email' => 'gg@gg',
            'rank' => '175'
        ]);
        
        User::create([
            'name' => 'NAO',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'20347830',
            'email' => 'hh@hh',
            'rank' => '175'
        ]);
        
        User::create([
            'name' => 'TuKi',
            'password' => '$2y$10$A/RpGH1uCgG1OvcesdaCn..wq.OFzDcjws04pmYr3nWr2VyXF.L56',
            'total_score' =>'20047830',
            'email' => 'ii@ii',
            'rank' => '170'
        ]);
        
    }
}
