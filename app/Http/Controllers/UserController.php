<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // Asegura que solo usuarios autenticados accedan

    public function __construct(){
        $this->middleware('auth'); 
    }
    
    // Método para obtener los registros en formato JSON
    public function getTableData(){
        $usuarios = User::select('id', 'name', 'role')->get();  // Solo selecciona los campos necesarios
        return datatables()->of($usuarios)
            ->addColumn('acciones', function ($usuario) {
                return view('User.actions', compact('usuario'));  // Vista para las acciones
            })
            ->make(true);
    }

    
    public function index(){
        $registros = User::paginate(10); // Obtener registros con paginación
        return view('User.RUIndex', compact('registros'));
    }

    public function store(Request $request){
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
    
    public function getUser($id) {
        dd($id); // Detiene la ejecución y muestra el ID
        $usuario = User::find($id);
        
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }
    
        return response()->json(['success' => true, 'usuario' => $usuario]);
    }
    /**
     * Actualiza un usuario existente
     */

     public function edit($id) {
        $usuario = User::find($id); // Busca el usuario en la base de datos
    
        if (!$usuario) {
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }
    
        return view('User.RUEdit', compact('usuario'));
    }
    
    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        
        // Reglas de validación
        $rules = [
            'nombre' => 'required|string|max:255',
            'rol' => 'required|in:Administrador,Editor,Visualizador',
        ];
        
        // Agregar reglas de validación para la contraseña solo si se está actualizando
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        // Validación
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        // Actualizar el usuario
        $user->nombre = $request->nombre;
        $user->rol = $request->rol;
        
        // Actualizar contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    /**
     * Elimina un usuario
     */
    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ]);
        }
    }
}


