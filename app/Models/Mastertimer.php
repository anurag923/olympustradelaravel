<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mastertimer extends Model
{
    use HasFactory;
    
    public function mastermarket(){
        return $this->belongsTo(MasterMarket::class)->select(['id','master_id','market_id','status']);
    }

    public function master(){
        return $this->belongsTo(Master::class);
    }

    public function masterfinalbet(){
        return $this->hasOne(masterfinalbet::class);
    }
}
