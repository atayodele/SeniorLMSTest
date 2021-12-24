<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Department;
use App\User;
use App\Role;
use App\Lecturer;
use Gate;
use Carbon\Carbon;
use DB;

class LecturerController extends Controller
{
    use MyDataTrait;

    public function index()
    {
        $departments = $this->getDepartments();
        $students = $this->paginate(Lecturer::orderBy('created_at', 'DESC')->get());
        return view('admin.lecturer.index', compact('students', 'departments'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|not_in:0',
                'fname' => 'required|string|min:3',
                'lname' => 'required|string|min:3',
                'email' => 'required|string|email|max:200|unique:users',
            ], [
                'department_id.required' => 'Select a department',
                'fname.required' => 'Firstname field is required',
                'lname.required' => 'Lastname field is required',
                'email.required' => 'Email address field is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make($request->lname);
            $user->save();
            $role = Role::select('id')->where('name', 'lecturer')->first();
            $user->roles()->attach($role);

            //insert into student table
            $query=array(
                'user_id'=>$user->id, 'department_id'=>$request->department_id,
                'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now()
            );
            DB::table('lecturers')->insert($query);
            toastr()->success("Lecturer Created Successfully", 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }
    }

    public function edit(Lecturer $lecturer)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.lecturer.index'));
        }
        $departments = $this->getDepartments();
        return view('admin.lecturer.edit', compact('lecturer', 'departments'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        try{
            $lecturer->department_id = $request->department_id;
            $update = $this->UpdateUserRecord($request->userId, $request->fname, $request->lname);
            ($lecturer->save()) ? toastr()->success('Lecturer has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.lecturer.index'));
            }
            $lecturer = Lecturer::findOrFail($request->id);
            $lecturer->delete();
            $user = User::findOrFail($lecturer->user_id);
            $user->roles()->detach();
            $user->delete();
            toastr()->success('Lecturer Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.lecturer.index');
        }
    }

    public function show(Lecturer $lecturer)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.lecturer.index'));
        }
        $LecturerCourses = $this->paginate($this->LecturerCourseList($lecturer->id));
        return view('admin.lecturer.show', compact('LecturerCourses','lecturer'));
    }

    public function AddLecturerToCourse(Request $request)
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
        return view('admin.lecturer.course');
    }
}
