<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (!Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->route('login')->with('error', 'Invalid username or password');
        }
        
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        return redirect()->route('home');
    }
}
