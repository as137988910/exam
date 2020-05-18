<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    public function admissions(){
        return $this->hasMany('App\Models\Admission','stu_id');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer','stu_id');
    }

    public function Papers(){
        return $this->belongsToMany('App\Models\Paper','grades','stu_id','paper_id')
            ->withPivot('id','score','addmission_id','status','publisher_id','publisher_name','joinflag')
            ->withTimestamps();
    }

    public function grades(){
        return $this->hasMany('App\Models\Grade','stu_id');
    }
}
