<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function teachers(){
        return $this->hasMany('App\Models\Teacher','subject_id');
    }
}
