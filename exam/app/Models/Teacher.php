<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    public function papers(){
        return $this->hasMany('App\Models\Paper','teacher_id');
    }

    public function publishPapers(){
        return $this->belongsToMany('App\Models\Paper','templates','teacher_id','paper_id')
            ->withPivot('id','begin','end','publish','status');
    }

    public function Template(){
        return $this->belongsTo('App\Models\Template');
    }

    public function subject(){
        return $this->hasOne('App\Models\Subject','subject_id');
    }
}
