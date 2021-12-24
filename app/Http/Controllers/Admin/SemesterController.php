<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Semester;
use Gate;

class SemesterController extends Controller
{
    
    use MyDataTrait;

    public function index()
    {
        $semesters = $this->paginate(Semester::orderBy('created_at', 'DESC')->get());
        return view('admin.semester.index', compact('semesters'));
    }

    public function store(Request $request)
    {
        try{
            // print_r($request->all()); exit;
            $validator = Validator::make($request->all(), [
                'semester_name' => 'required|string|unique:semesters,name'
            ], [
                'semester_name.required' => 'Semester name is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new Semester();
            $create->name = $request->semester_name;
            $create->save();
            toastr()->success("Semester Created Successfully", 'Springfield');
            return redirect()->route('admin.semester.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.semester.index');
        }
    }
    public function edit(Semester $semester)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.semester.index'));
        }
        return view('admin.semester.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        try{
            //check is name already exist
            $validator = Validator::make($request->all(), [
                'semester_name' => 'required|string|unique:semesters,name'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $semester->name = $request->semester_name;
            ($semester->save()) ? toastr()->success($semester->name .' has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.semester.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.semester.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.semester.index'));
            }
            $semester = Semester::findOrFail($request->id);
            $semester->delete();
            toastr()->success('Semester Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.semester.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.semester.index');
        }
    }
}
