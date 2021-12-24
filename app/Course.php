<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{
    protected $fillable = [
        'Name', 'Code', 'Units', 'department_id'
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public static function CheckDuplicateCourses($code, $name, $dept)
    {
        $check = DB::table("courses")
                        ->where("department_id",$dept)
                        ->where('code', $code)
                        ->where('name', $name)
                        ->first();
        if($check){
            return true;
        }
        return false;
    }
}
