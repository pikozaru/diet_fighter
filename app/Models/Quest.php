<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;
    
    protected $dates = [
        'start_at',
        'end_at'
    ];
    
    public function actionHistories()
    {
        return $this->hasMany('App\Models\ActionHistory');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function questItems()
    {
        return $this->hasMany('App\Models\QuestItems');
    }
    
    public function records()
    {
        return $this->belongsToMany('App\Models\Record');
    }
    
    public function enemyDataBases()
    {
        return $this->hasMany('App\Models\EnemyDatabase');
    }
}
