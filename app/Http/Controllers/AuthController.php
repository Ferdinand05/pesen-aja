<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only(['email', 'password']), $request->remember_me)) {
            return to_route('dashboard')->with('message', 'Welcome Back!');
        }

        throw ValidationException::withMessages([
            'email' => 'Your Credentials does not match with our records'
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
    }
}
