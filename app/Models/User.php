<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'height',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $dates = ['post_at'];
    
    public function quests()
    {
        return $this->hasMany('App\Models\Quest');
    }
    
    public function possessionItems()
    {
        return $this->hasMany('App\Models\PossessionItem');
    }
    
    public function possessionSkills()
    {
        return $this->hasMany('App\Models\PossessionSkills');
    }
    
    public function rankings()
    {
        return $this->hasMany('App\Models\PossessionSkills');
    }
    
    public function questItems()
    {
        return $this->hasMany('App\Models\QuestItems');
    }
    
    
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail);
        $this->notify(new \App\Notifications\ResetPassword);
    }
}
