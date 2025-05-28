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

    //  Busca al usuario en la tabla users.
    $user = User::where('name', $request->nombre)->first();
    if (!$user) {
        return back()->withErrors(['error' => 'Usuario no encontrado']);
    }

    //  Busca el estado del usuario en la tabla registro_rols.
    $rol = \App\Models\RegistroRol::where('rol', $user->role)->first();
    if (!$rol) {
        return back()->withErrors(['error' => 'Rol no encontrado. Contacta al administrador.']);
    }

    //  Si el rol no es Administrador y está inactivo, bloquea login
    if ($user->role !== 'Administrador' && $rol->estado == 0) {
        return back()->withErrors(['error' => 'Tu cuenta está inactiva. Contacta al administrador.']);
    }

    // Intentar autenticar usando name y password
    if (!Auth::attempt(['name' => $request->nombre, 'password' => $request->password])) {
        return back()->withErrors(['error' => 'Credenciales incorrectas']);
    }

        return redirect()->intended('/menu'); 
    }

    
    public function showRegister()
    {   
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:usuario,visualizador,Administrador',
        ]);

        User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'estado' => $request->estado,
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
