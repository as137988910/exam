<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table='templates';

    public function papers(){
        return $this->belongsTo('App\Models\Paper');
    }
}
