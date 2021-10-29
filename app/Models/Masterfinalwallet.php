<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterfinalwallet extends Model
{
    use HasFactory;
    public function master(){
        return $this->belongsTo(Master::class);
    }
}
