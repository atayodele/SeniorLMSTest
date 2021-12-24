<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=['RegNo', 'department_id','user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function department(){
        return $this->belongsTo('App\Department');
    }
}
