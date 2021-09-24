<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_active_bet(){
        return $this->hasMany(Useractivebet::class);
    }

    public function user_final_bet(){
        return $this->hasMany(Userfinalbet::class);
    }

    public function user_transactionwallet(){
        return $this->hasMany(Usertransactionwallet::class)->select(array('id','user_id','amount'));
    }

    public function user_finalwallet(){
        return $this->hasOne(Userfinalwallet::class);
    }
}
