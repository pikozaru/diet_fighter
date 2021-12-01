<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    
    protected $table = "records";
    
    protected $dates = ['post_at'];
    
    public function quest()
    {
        return $this->hasOne('App\Models\Quest');
    }
}
