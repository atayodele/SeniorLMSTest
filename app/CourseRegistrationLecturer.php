<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRegistrationLecturer extends Model
{
    protected $fillable = [
        'lecturer_id', 'course_registration_id'
    ];

}
