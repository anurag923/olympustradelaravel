<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betcategory extends Model
{
    use HasFactory;

    public function useractivebet(){
        return $this->belongsTo(Useractivebet::class);
    }

    public function userfinalbet(){
        return $this->belongsTo(Userfinalbet::class);
    }

    public function betcategoryprice(){
        return $this->hasMany(Betcategoryprice::class);
    }
}
