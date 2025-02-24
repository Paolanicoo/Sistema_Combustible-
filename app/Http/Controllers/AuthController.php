<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

        $request->session()->regenerate();
 

        return redirect()->intended('/menu');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ]);
}


    public function showRegister()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
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
