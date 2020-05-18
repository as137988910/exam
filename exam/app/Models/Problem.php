<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    //
    public function solution(){
        return $this->hasOne('App\Models\Solution','problem_id');
    }
    public function answers(){
        return $this->hasMany('App\Models\Answer','problem_id');
    }
    public function papers(){
        return $this->belongsToMany('App\Models\Paper','problems_papers','problem_id','paper_id')
            ->withPivot('id','sequence')
            ->withTimestamps();
    }
}
