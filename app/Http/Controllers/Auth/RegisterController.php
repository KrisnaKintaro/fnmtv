<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->name, // Asumsikan username dari name
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'viewer', // Default role
            'status' => 'active',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}