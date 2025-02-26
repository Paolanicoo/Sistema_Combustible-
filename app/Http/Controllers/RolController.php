<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol; 
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }

    public function getData(Request $request)
    {    
        if ($request->ajax()) {
            // Aquí puedes recuperar los roles desde la base de datos
            $roles = RegistroRol::select('id', 'rol')->get();
            return datatables()->of($roles)->toJson();
         }

            return view('RegistroRol.RRCreate'); // En caso de no ser una solicitud AJAX

    }
}
