<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroRol; 
use Illuminate\Support\Facades\Auth;

class RegistroRolController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }

    public function getData(Request $request){    
        if ($request->ajax()) {
            // Recuperar los roles desde la base de datos
            $roles = RegistroRol::select('id', 'tipo_rol')->get();
        
            return datatables()->of($roles)
                ->addColumn('acciones', function ($rol) {
                    return '
                        <button class="btn btn-warning btn-sm" onclick="editarRol('.$rol->id.')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="desactivarRol('.$rol->id.')">
                            <i class="fas fa-times"></i>
                        </button>
                    ';
                })
                ->rawColumns(['acciones']) // Permitir HTML en esta columna
                ->toJson();
        }
        
        return view('RegistroRol.RRCreate'); // En caso de no ser una solicitud AJAX
    }

    public function desactivarRol($id)
    {
        // Encuentra el rol por ID
        $rol = RegistroRol::find($id);
    
        if ($rol) {
            // Realiza la acción de desactivar el rol
            $rol->estado = 'desactivado'; // Cambia el campo según lo que necesites
            $rol->save();
    
            // Devuelve una respuesta exitosa
            return response()->json(['message' => 'Rol desactivado exitosamente']);
        }
    
        // Si no se encuentra el rol, devuelve un error 404
        return response()->json(['message' => 'Rol no encontrado'], 404);
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editarRol($id){
        $rol = RegistroRol::find($id);
            if ($rol) {
                return response()->json($rol);
            }
        return response()->json(['message' => 'Rol no encontrado'], 404);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
