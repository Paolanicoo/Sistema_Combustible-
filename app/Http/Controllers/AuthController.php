<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); // Debes tener el archivo resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            Auth::login(Auth::user());
            return redirect()->route('menu'); // Redirige correctamente a la vista 'menu'
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas']);
    }

    public function showRegister()
    {
        return view('auth.register'); // Debes tener el archivo resources/views/auth/register.blade.php
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
