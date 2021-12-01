<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    
    public function possessionSkill()
    {
        return $this->hasOne('App\Models\PossessionSkills');
    }
    
    public static function penetrationAttack($attackPoint)
    {
        $random = mt_rand(0, 4);
        if($random === 0) {
            $penetrationAttackPoint = $attackPoint;
        } else {$penetrationAttackPoint = 0;}
        
        return $penetrationAttackPoint;
    }
}
