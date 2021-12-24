<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Department;
use App\Course;
use Gate;

class CourseController extends Controller
{
    use MyDataTrait;

    public function index()
    {
        $departments = $this->getDepartments();
        $courses = $this->paginate(Course::orderBy('created_at', 'DESC')->get());
        return view('admin.course.index', compact('courses', 'departments'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|not_in:0',
                'code' => 'required|string',
                'name' => 'required|string',
                'unit' => 'required|numeric',
            ], [
                'department_id.required' => 'Select a department',
                'code.required' => 'Code field is required',
                'name.required' => 'Course name field is required',
                'unit.required' => 'Unit field is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $check = Course::CheckDuplicateCourses($request->code, $request->name, $request->department_id);
            if($check){
                toastr()->error("Course code with name already exist for this department...", 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new Course();
            $create->code = $request->code;
            $create->name = $request->name;
            $create->units = $request->unit;
            $create->department_id = $request->department_id;
            $create->save();
            toastr()->success("Course Created Successfully", 'Springfield');
            return redirect()->route('admin.course.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.course.index');
        }
    }

    public function edit(Course $course)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.course.index'));
        }
        $departments = $this->getDepartments();
        return view('admin.course.edit', compact('course', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        try{
            $validator = Validator::make($request->all(), [
                'unit' => 'required|numeric',
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $course->code = $request->code;
            $course->name = $request->name;
            $course->units = $request->unit;
            $course->department_id = $request->department_id;
            ($course->save()) ? toastr()->success('Course has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.course.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.course.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.course.index'));
            }
            $course = Course::findOrFail($request->id);
            $course->delete();
            toastr()->success('Course Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.course.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.course.index');
        }
    }
}