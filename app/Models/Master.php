<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Master extends Authenticatable
{
    use HasApiTokens, HasFactory;

    public function master_finalwallet(){
        return $this->hasOne(Masterfinalwallet::class);
    }

    public function master_market(){
        return $this->hasMany(MasterMarket::class);
    }

    public function mastertimer(){
        return $this->hasOne(Mastertimer::class);
    }

    public function masterfinalbet(){
        return $this->hasMany(masterfinalbet::class);
    }
}
