<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    
    // Método para obtener los registros en formato JSON
    public function getTableData()
    {
        $usuarios = User::select('id', 'name', 'role')->get();  // Solo selecciona los campos necesarios
        return datatables()->of($usuarios)
            ->addColumn('acciones', function ($usuario) {
                return view('User.actions', compact('usuario'));  // Vista para las acciones
            })
            ->make(true);
    }

    
    public function index()
    {
        $registros = User::paginate(10); // Obtener registros con paginación
        return view('User.RUIndex', compact('registros'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'rol' => 'required|string|in:Administrador,Editor,Visualizador',
                'password' => 'required|min:6|confirmed',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'rol.required' => 'El rol es obligatorio',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            User::create([
                'name' => $request->nombre,
                'role' => $request->rol,
                'password' => bcrypt($request->password), // Encripta la contraseña
            ]);

            return response()->json(['success' => true, 'message' => 'Usuario creado correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear el usuario'], 500);
        }
    }



}
