<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enemies extends Model
{
    use HasFactory;
    
    public function actionHistories()
    {
        return $this->hasMany('App\Models\ActionHistory');
    }
    
    public function enemyDataBases()
    {
        return $this->hasMany('App\Models\EnemyDatabase');
    }
    
    public static function pop_probability($level)
    {
        if($level < 50) {
            $random = mt_rand(1, 7);
            if($random === 6) {
                $randomSilver = mt_rand(1, 10);
                if($randomSilver !== 1) {
                    $random = 1;
                }
            } elseif($random === 7) {
                $randomGold = mt_rand(1, 20);
                if($randomGold !== 1) {
                    $random = 2;
                }
            }
        } elseif($level >= 50 and $level < 100) {
            $random = mt_rand(6, 12);
            if($random === 6) {
                $randomSilver = mt_rand(1, 10);
                if($randomSilver !== 1) {
                    $random = 1;
                }
            } elseif($random === 7) {
                $randomGold = mt_rand(1, 20);
                if($randomGold !== 1) {
                    $random = 2;
                }
            } elseif($random === 8) {
                $randomSoul = mt_rand(1, 7);
                if($randomSoul !== 1) {
                    $random = 5;
                }
            }
        } elseif($level >= 100) {
            $random = mt_rand(1, 12);
            if($random === 6) {
                $randomSilver = mt_rand(1, 10);
                if($randomSilver !== 1) {
                    $random = 1;
                }
            } elseif($random === 7) {
                $randomGold = mt_rand(1, 20);
                if($randomGold !== 1) {
                    $random = 2;
                }
            } elseif($random === 8) {
                $randomSoul = mt_rand(1, 7);
                if($randomSoul !== 1) {
                    $random = 5;
                }
            }
        }
        
        return $random;
    }
}
