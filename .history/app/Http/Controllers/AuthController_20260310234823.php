<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // placeholder: authenticate manually or redirect
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        // placeholder: perform logout
        return redirect()->route('admin.login');
    }
}
