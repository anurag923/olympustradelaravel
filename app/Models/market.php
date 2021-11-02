<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market extends Model
{
    use HasFactory;
    
    public function payouts(){
        return $this->hasMany(Timer::class);
    }

    public function mastermarket(){
        return $this->hasOne(MasterMarket::class);
    }
}
