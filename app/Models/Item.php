<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    public function possessionItem()
    {
        return $this->hasOne('App\Models\PossessionItem');
    }
    
    public function questItems()
    {
        return $this->hasMany('App\Models\QuestItem');
    }
}
