<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() 
    {
        return view('auth.login');
    }

    public function login_confirm(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('classes');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function register() 
    {
        return view('auth.register');
    }

    public function register_confirm(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'password' => ['required'],
            'confirmpassword' => ['required']
        ]);

        if('password' != 'confirmpassword')
            return back()->withErrors([
                'password' => 'Password and Confirm Password do not match.',
                'confirmpassword' => 'Password and Confirm Password do not match.'
            ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('homepage');
        }

        return back()->withErrors([
            'email' => 'Invalid email.'
        ]);
    }

    public function forgot(Request $request) 
    {
        //
        return redirect()->route('homepage');
    }

    public function logout(Request $request) 
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
