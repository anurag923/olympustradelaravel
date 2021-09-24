<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betcategoryprice extends Model
{
    use HasFactory;

    public function betcategory(){
        return $this->belongsTo(Betcategory::class)->select(array('id','category_name'));
    }
}
