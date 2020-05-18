<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    //
    public function students(){
        return $this->belongsToMany('App\Models\Student','grades','paper_id','stu_id')
            ->withPivot('id','score','addmission_id')
            ->withTimestamps();
    }
    public function problems(){
        return $this->belongsToMany('App\Models\Problem','problems_papers','paper_id','problem_id')
            ->withPivot('id','sequence');
    }

    public function teachers(){
        return $this->belongsToMany('App\Models\Teacher','templates','paper_id','teacher_id')
            ->withPivot('id','begin','end');
    }

    public function template(){
        return $this->belongsTo('App\Models\Template');
    }
}
