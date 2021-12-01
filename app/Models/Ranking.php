<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;
    
    protected $dates = [
        'start_at',
        'end_at'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
