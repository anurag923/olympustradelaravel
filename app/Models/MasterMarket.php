<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMarket extends Model
{
    use HasFactory;

    public function market(){
        return $this->belongsTo(market::class);
    }

    public function master(){
        return $this->belongsTo(Master::class);
    }

    public function mastertimer(){
        return $this->hasMany(Mastertimer::class,'mastermarket_id');
    }
}
