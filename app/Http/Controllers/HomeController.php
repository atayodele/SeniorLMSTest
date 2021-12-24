<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Lecturer;
use App\Level;
use App\Semester;
use App\Session;
use App\Course;
use App\Department;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::count();
        $lecturers = Lecturer::count();
        $level = level::count();
        $session = Session::count();
        $semester = Semester::count();
        $courses = Course::count();
        $dept = Department::count();
        return view('home', compact('students', 'level', 'session','semester','courses','dept', 'lecturers'));
    }
}
