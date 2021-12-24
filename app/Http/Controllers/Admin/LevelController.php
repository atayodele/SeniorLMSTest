<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Level;
use Gate;

class LevelController extends Controller
{
    
    use MyDataTrait;

    public function index()
    {
        $levels = $this->paginate(Level::orderBy('created_at', 'DESC')->get());
        return view('admin.level.index', compact('levels'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'level_name' => 'required|string|unique:levels,name'
            ], [
                'level_name.required' => 'Level name is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new Level();
            $create->name = $request->level_name;
            $create->save();
            toastr()->success("Level Created Successfully", 'Springfield');
            return redirect()->route('admin.level.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.level.index');
        }
    }
    public function edit(Level $level)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.level.index'));
        }
        return view('admin.level.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        try{
            //check is name already exist
            $validator = Validator::make($request->all(), [
                'level_name' => 'required|string|unique:levels,name'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $level->name = $request->level_name;
            ($level->save()) ? toastr()->success($level->name .' has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.level.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.level.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.level.index'));
            }
            $level = Level::findOrFail($request->id);
            $level->delete();
            toastr()->success('Level Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.level.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.level.index');
        }
    }
}
