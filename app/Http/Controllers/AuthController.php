<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{

    public function index() 
    {
        return view('auth.login');
    }

    /**
     * Attempt to Log user in to the Application.
     * 
     * @param Illuminate\Http\Request request
     */
    public function login_confirm(Request $request)
    {
        //Validate credentials.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        //Attempt login and redirect upon success.
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('classes');
        }

        //Return error if invalid Credentials.
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    /**
     * Redirect to Register page
     */
    public function register() 
    {
        return view('auth.register');
    }

    /**
     * Attempting to register a user.
     * 
     * @param Illuminate\Http\Request request
     */
    public function register_confirm(Request $request)
    {
        //Checking user credentials are valid.
        $credentials = $request->validate([
            'email' => ['required', 'unique:users', 'email'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'password' =>  ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ]); 

        //Confirming Passwords match.
        if($request->password != $request->confirmpassword)
            return back()->withErrors([
                'password' => 'Password and Confirm Password do not match.',
                'confirmpassword' => 'Password and Confirm Password do not match.'
            ]);

        //Adding user to database if valid credentials.
        if ($credentials) {
            DB::table('users')->insert([
                'fullname' => $request->firstname . ' ' . $request->lastname,
                'username' => substr($request->firstname, 0) . ' ' . substr($request->lastname, 0) . rand(10000, 99999),
                'email' => $request->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'password' => Hash::make($request->password)
            ]);

            //Get automatically assigned id for assigning role.
            $user_id = DB::table('users')
            ->select('id', 'fullname')
            ->where('email', '=' , $request->email)
            ->get();

            //Assign user the 'Unverified' role.
            DB::table('user_role')->insert([
                'user_id' => $user_id[0]->id,
                'role_id' => 8
            ]);  
            
            //Create login_credentials and attempt to Authenticate created User.
            $login_credentials = array('email' => $request->email, 
            'password' => $request->password);

            //Login and redirect.
            if (Auth::attempt($login_credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/home');
            }
        }

        return back();
    }

    /**
     * Forgot password functionality, to be added.
     * 
     * @param Illuminate\Http\Request request
     */
    public function forgot(Request $request) 
    {
        //
        return redirect()->route('homepage');
    }

    /**
     * Log user out of the Application.
     * 
     * @param Illuminate\Http\Request request
     */
    public function logout(Request $request) 
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
