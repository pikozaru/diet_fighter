<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionHistory extends Model
{
    use HasFactory;
    
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest');
    }
    
    public function enemys()
    {
        return $this->belongsToMany('App\Models\Enemies');
    }
    
    public function enemyDataBases()
    {
        return $this->belongsToMany('App\Models\EnemyDatabase');
    }
}
