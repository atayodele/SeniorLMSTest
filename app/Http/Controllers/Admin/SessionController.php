<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\MyDataTrait;
use App\Session;
use Gate;

class SessionController extends Controller
{
    use MyDataTrait;

    public function index()
    {
        $sessions = $this->paginate(Session::orderBy('created_at', 'DESC')->get());
        return view('admin.session.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        try{
            // print_r($request->all()); exit;
            $validator = Validator::make($request->all(), [
                'session_name' => 'required|string|unique:sessions,name'
            ], [
                'session_name.required' => 'Session name is required'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            //insert into db
            $create = new Session();
            $create->name = $request->session_name;
            $create->save();
            toastr()->success("Session Created Successfully", 'Springfield');
            return redirect()->route('admin.session.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.session.index');
        }
    }
    public function edit(Session $session)
    {
        if(Gate::denies('editOrDelete')){
            return redirect(route('admin.session.index'));
        }
        return view('admin.session.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        try{
            //check is name already exist
            $validator = Validator::make($request->all(), [
                'session_name' => 'required|string|unique:sessions,name'
            ]);
            if ($validator->fails())
            {
                toastr()->error($validator->messages()->first(), 'Springfield');
                return redirect()->back()->withInput();
            }
            $session->name = $request->session_name;
            ($session->save()) ? toastr()->success($session->name .' has been updated', 'Springfield') : toastr()->error('An error Occured!', 'Springfield');
            return redirect()->route('admin.session.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.session.index');
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Gate::denies('editOrDelete')){
                return redirect(route('admin.session.index'));
            }
            $session = Session::findOrFail($request->id);
            $session->delete();
            toastr()->success('Session Deleted Sucessfully', 'Springfield');
            return redirect()->route('admin.session.index');
        }catch(ModelNotFoundException $ex){
            toastr()->error("System Encounter an error", 'Springfield');
            return redirect()->route('admin.session.index');
        }
    }
}
