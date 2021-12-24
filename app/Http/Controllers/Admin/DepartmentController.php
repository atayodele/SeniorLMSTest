<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Department;
use Gate;
use DB;

class DepartmentController extends Controller
{
    use MyDataTrait;

    public function index()
    {
        $departments = $this->paginate(Department::orderBy('created_at', 'DESC')->get());
        return view('admin.dept.index', compact('departments'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'dept_name' => 'required|string|unique:departments,name'
            ], [
                'dept_name.required' => 'Department name is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new Department();
            $create->name = $request->dept_name;
            $create->save();
            toastr()->success("Department Created Successfully", 'Springfield');
            return redirect()->route('admin.dept.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.dept.index');
        }
    }
    public function edit(Department $dept)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.dept.index'));
        }
        return view('admin.dept.edit', compact('dept'));
    }

    public function update(Request $request, Department $dept)
    {
        try{
            //check is name already exist
            $validator = Validator::make($request->all(), [
                'dept_name' => 'required|string|unique:departments,name'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $dept->name = $request->dept_name;
            ($dept->save()) ? toastr()->success($dept->name .' has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.dept.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.dept.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.dept.index'));
            }
            $dept = Department::findOrFail($request->id);
            $del = DB::table('courses')->where('department_id',$request->id)->delete();
            $dept->delete();
            toastr()->success('Department Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.dept.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.dept.index');
        }
    }
}
