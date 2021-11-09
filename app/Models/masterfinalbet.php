<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterfinalbet extends Model
{
    use HasFactory;
    public function master(){
        return $this->belongsTo(Master::class);
    }
    public function mastertimer(){
        return $this->belongsTo(Mastertimer::class);
    }
}
