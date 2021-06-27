<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
   /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest:department')->except('logout');
    }

    // ===============================================================================

    function login_form() {
        return view('login');
    }
    
    function login(Request $req) {
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('department')->attempt(['username'=>$req->username, 'password'=>$req->password], $req->get('remember'))) {
            return redirect()->intended('/dashboard')->with('alert', 'Alert!');
        } else {
            return back()->withInput($req->only('username', 'remember'))->with('error', 'Username or Password is invalid. Please try again.');
        }
    }

    function register(Request $req) {
        $name = $req->input('name');
        $abb = $req->input('abbreviation');
        if(Course::all()->where('name', $name)->first() != null || Course::all()->where('abbreviation', $abb)->first() != null ) {
            /* return back()->withInput($req->only('username'))->with('error', 'Course already exists. Please try again.'); */
            return response()->json(['course'=>'Course already exists. Please try again.']);
        } else if(Department::all()->where('username', $req->input('username'))->first() != null) {
            /* return back()->withInput($req->only('username'))->with('error', 'Username already exists. Please try again.'); */
            return response()->json(['username'=>'Username already exists. Please try again.']);
        } else {
            $add = new Course;
            $add->name = $req->input('course');
            $add->abbreviation = $req->input('abbreviation');
            $add->save();
            $add2 = new Department;
            $add2->name = $req->input('name');
            $add2->dept_head = $req->input('dept_head');
            $add2->course_id = $add->id;
            $add2->username = $req->input('username');
            $add2->password = Hash::make($req->password);
            $add2->set_semester = 1;
            $add2->school_year_from = Carbon::now()->format('Y');
            $add2->school_year_to = Carbon::now()->addYears(1)->format('Y');
            $add2->save();
            /* return redirect()->intended('/')->with('success', 'Registered Successfully!'); */
            return response()->json(['success'=>'/']);
        }
    }

    function logout(Request $req) {
        if(Auth::guard('department')->user()) {
            Auth::guard('department')->logout();
            return redirect()->intended('/');
        }
    }
}
