<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnemyDatabase extends Model
{
    use HasFactory;
    
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest');
    }
    
    public function enemy()
    {
        return $this->belongsTo('App\Models\Enemies');
    }
    
    public function actionHistories()
    {
        return $this->hasMany('App\Models\ActionHistory');
    }
    
}
