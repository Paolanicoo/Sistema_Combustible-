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

     $request->validate([
        'nombre' => 'required|string',
        'password' => 'required'
    ]);

    if (Auth::attempt(['name' => $request->nombre, 'password' => $request->password])) {

        $request->session()->regenerate();
 

        return redirect()->intended('/menu');
    }

    return back()->withErrors([
        'name' => 'Las credenciales no coinciden con nuestros registros.',
    ]);
}


    public function showRegister()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:admin,usuario,visualizador',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
