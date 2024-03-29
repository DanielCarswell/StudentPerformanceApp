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
    /**
    * Returns login.
    *
    * @return view     
    */
    public function index() 
    {
        return view('auth.login');
    }

    /**
     * Attempt to Log user in to the Application.
     * 
     * @param Illuminate\Http\Request request
     * @return route
     * @return back error message
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
            //Creates session and return intended route.
            $request->session()->regenerate();
            return redirect()->intended('classes');
        }

        //Return error if invalid Credentials.
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    /**
    * Redirect to Register page.
    *
    * @return view     
    */
    public function register() 
    {
        return view('auth.register');
    }

    /**
     * Attempting to register a user.
     * 
     * @param Illuminate\Http\Request request
     * @return previous.view
     * @return intended.redirect
     * @return back error message(s)
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

        //Confirming Passwords match or returning error.
        if($request->password != $request->confirmpassword)
            return back()->withErrors([
                'password' => 'Password and Confirm Password do not match.',
                'confirmpassword' => 'Password and Confirm Password do not match.'
            ]);

        //Adding user to database if valid credentials with hashed password.
        if ($credentials) {
            DB::table('users')->insert([
                'fullname' => $request->firstname . ' ' . $request->lastname,
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
                'role_id' => 5
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
     * Log user out of the Application.
     * 
     * @param Illuminate\Http\Request request
     * @return view
     */
    public function logout(Request $request) 
    {
        //Logs authenticated user out.
        Auth::logout();

        //Resets session details.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('/home/index');
    }
}
