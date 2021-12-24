<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'student_id', 'course_id', 'session_id', 'semester_id', 'level_id'
    ];

    public function student(){
        return $this->belongsTo('App\User');
    }

    public function level(){
        return $this->belongsTo('App\Level');
    }
    public function semester(){
        return $this->belongsTo('App\Semester');
    }
    public function Stdsession(){
        return $this->belongsTo('App\Session');
    }
    public function course(){
        return $this->belongsTo('App\Course');
    }
}
