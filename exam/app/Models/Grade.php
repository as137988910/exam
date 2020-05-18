<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function papers(){
//        return $this->
    }

    public function students(){
        return $this->belongsTo('App\Models\Student');
    }
}
