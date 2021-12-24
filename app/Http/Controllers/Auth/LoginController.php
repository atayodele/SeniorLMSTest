<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request){
        Auth::logout();
        toastr()->info("See you some other time, Bye!", 'LMS');
        return redirect('/login');
    }

    public function redirectTo()
    {
        if(Auth::user()->hasRole('admin')){
            $this->redirectTo = route('admin.users.index');
            toastr()->success('Welcome Back!', 'LMS');
            return $this->redirectTo;
        }
        $this->redirectTo = route('home');
        toastr()->success('Welcome Back!', 'LMS');
        return $this->redirectTo;
    }

    public function HandleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
         ]);
         if ($validator->fails())
         {
             toastr()->error($validator->messages()->first(), 'LMS');
             return redirect()->back()->withInput();
         }

        $user = User::where('email', $request->email)->first();
        if($user !== null){
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                if(Auth::user()->hasRole('admin')){
                    $user->last_login = Carbon::now();
                    $user->save();
                    toastr()->success('Welcome Back!', 'Springfield');
                    return redirect('/');
                }elseif(Auth::user()->hasRole('lecturer')){
                    $user->last_login = Carbon::now();
                    $user->save();
                    toastr()->success('Welcome Back!', 'Springfield');
                    return redirect('/author');
                }else{
                    $user->last_login = Carbon::now();
                    $user->save();
                    toastr()->success('Welcome Back!', 'Springfield');
                    return redirect('/student');
                }
            }else{
                $this->redirectTo = route('login');
                toastr()->error('Invalid Email and Password!', 'Springfield');
                return redirect()->back()->withInput();
            }
        }else{
            $this->redirectTo = route('login');
            toastr()->error('Invalid Credentials!', 'Springfield');
            return redirect('/login');
        }
    }
}
