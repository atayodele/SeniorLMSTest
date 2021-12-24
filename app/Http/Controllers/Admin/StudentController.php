<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Traits\MyDataTrait;
use App\Department;
use App\User;
use App\Role;
use App\Student;
use App\CourseRegistration;
use Gate;
use Carbon\Carbon;
use DB;

class StudentController extends Controller
{
    use MyDataTrait;

    public function index()
    {
        $departments = $this->getDepartments();
        $students = $this->paginate(Student::orderBy('created_at', 'DESC')->get());
        return view('admin.student.index', compact('students', 'departments'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|not_in:0',
                'fname' => 'required|string|min:3',
                'lname' => 'required|string|min:3',
                'regNo' => 'required|string|min:3',
                'email' => 'required|string|email|max:200|unique:users',
            ], [
                'department_id.required' => 'Select a department',
                'fname.required' => 'Firstname field is required',
                'lname.required' => 'Lastname field is required',
                'regNo.required' => 'Matric number field is required',
                'email.required' => 'Email address field is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $check = User::CheckDuplicateRegNo($request->regNo, $request->department_id);
            if($check){
                toastr()->error("Matric number has been taken", 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make($request->lname);
            $user->save();
            $role = Role::select('id')->where('name', 'student')->first();
            $user->roles()->attach($role);

            //insert into student table
            $query=array(
                'RegNo'=>$request->regNo, 'user_id'=>$user->id, 'department_id'=>$request->department_id,
                'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()
            );
            DB::table('students')->insert($query);
            toastr()->success("Student Created Successfully", 'Springfield');
            return redirect()->route('admin.student.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.student.index');
        }
    }

    public function show(Student $student)
    {
        $sessions = $this->GetSessions();
        $semesters = $this->GetSemester();
        $levels = $this->GetLevels();
        $courses = $this->GetCourses();
        $studentCourses = $this->paginate($this->CourseRegistrationList($student->id));
        return view('admin.student.show', compact('sessions', 'semesters','courses','levels', 'student', 'studentCourses'));
    }

    public function edit(Student $student)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.student.index'));
        }
        $departments = $this->getDepartments();
        return view('admin.student.edit', compact('student', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        try{
            $student->RegNo = $request->regNo;
            $student->department_id = $request->department_id;
            $update = $this->UpdateUserRecord($request->userId, $request->fname, $request->lname);
            ($student->save()) ? toastr()->success('Student has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.student.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.student.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.student.index'));
            }
            $student = Student::findOrFail($request->id);
            $student->delete();
            $user = User::findOrFail($student->user_id);
            $user->roles()->detach();
            $user->delete();
            toastr()->success('Student Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.student.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.student.index');
        }
    }

    public function AddUserToCourse(Request $request)
    {
        try{
            // print_r($request->all()); exit;
            $validator = Validator::make($request->all(), [
                'session_id' => 'required|not_in:0',
                'semester_id' => 'required|not_in:0',
                'level_id' => 'required|not_in:0',
                'course_id' => 'required|not_in:0'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new CourseRegistration();
            $create->session_id = $request->session_id;
            $create->semester_id = $request->semester_id;
            $create->level_id = $request->level_id;
            $create->course_id = $request->course_id;
            $create->student_id = $request->StudentId;
            $create->save();
            toastr()->success("Course registration Successfully", 'Springfield');
            return redirect('admin/student/'.$request->studentId.'');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect('admin/student/'.$request->studentId.'');
        }
    }
    
    public function MyCourses()
    {
        $std = $this->GetStudentId(Auth::user()->id);
        $studentCourses = $this->paginate($this->CourseRegistrationList($std->id));
        return view('admin.student.show_course', compact('studentCourses'));
    }
}
