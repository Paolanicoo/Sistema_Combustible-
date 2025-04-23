<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); 
    }

    // Método para obtener los registros en formato JSON
    public function getTableData(){
        $usuarios = User::select('id', 'name', 'role', 'is_protected')->get();
        return datatables()->of($usuarios)
            ->addColumn('acciones', function ($usuario) {
                return view('User.actions', compact('usuario'));
            })
            ->make(true);
    }

    public function index(){
        $registros = User::paginate(10);
        return view('User.RUIndex', compact('registros'));
    }

    public function create()
    {
        return view('User.RUCreate'); // Vista para formulario de nuevo usuario
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:15|unique:users,name', 
                'rol' => 'required|string|in:Administrador,Usuario,Visualizador',
                'password' => 'required|min:6|confirmed',
                'is_protected' => 'boolean',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.unique' => 'Este nombre ya está en uso, elige otro', 
                'rol.required' => 'El rol es obligatorio',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors() // Retorna errores correctamente
                ], 422);
            }
    
            // Guardar usuario correctamente
            $user = new User();
            $user->name = $request->nombre;
            $user->role = $request->rol;
            $user->password = bcrypt($request->password);
            $user->is_protected = $request->has('is_protected') ? $request->is_protected : false;
            $user->save();
    
            return response()->json(['success' => true, 'message' => 'Usuario creado correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear el usuario'], 500);
        }
    }
    

    public function edit($id)
    {
        try {
            $usuario = User::findOrFail($id); // Buscar usuario por ID
            
            // Verificar si el usuario está protegido
            if ($usuario->is_protected) {
                return redirect()->route('user.index')->with('error', 'Este usuario administrador está protegido y no puede ser editado');
            }

            return view('User.RUEdit', compact('usuario')); // Retornar la vista con el usuario
        } catch (\Exception $e) {
            \Log::error('Error al buscar usuario: ' . $e->getMessage());

            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }
    }

    public function update(Request $request, $id) {
        try {
            $usuario = User::findOrFail($id);
            
            // Verificar si el usuario está protegido
            if ($usuario->is_protected) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuario administrador está protegido y no puede ser modificado'
                ], 403);
            }
    
            // Validación de datos
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:users,name,' . $id,
                'rol' => 'required|string|in:Administrador,Usuario,Visualizador',
                'password' => 'nullable|min:6|confirmed',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.unique' => 'Este nombre ya está en uso, elige otro',
                'rol.required' => 'El rol es obligatorio',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Verificar cambios específicos
            $nombreActual = $usuario->name;
            $rolActual = $usuario->role;
            
            $nombreNuevo = $request->nombre;
            $rolNuevo = $request->rol;
    
            // Bandera para detectar cambios
            $seActualizo = false;
    
            // Verificar cambio de nombre
            if ($nombreActual !== $nombreNuevo) {
                $usuario->name = $nombreNuevo;
                $seActualizo = true;
            }
    
            // Verificar cambio de rol
            if ($rolActual !== $rolNuevo) {
                $usuario->role = $rolNuevo;
                $seActualizo = true;
            }
    
            // Verificar cambio de contraseña
            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
                $seActualizo = true;
            }
    
            // Si no hubo cambios, devolver respuesta específica
            if (!$seActualizo) {
                return response()->json([
                    'success' => true,
                    'noChanges' => true,  // Nuevo campo para indicar que no hubo cambios
                    'message' => 'No se detectaron modificaciones'
                ]);
            }
    
            // Guardar cambios
            $usuario->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente'
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario'
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Verificar si el usuario está protegido
            if ($user->is_protected) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuario administrador está protegido y no puede ser eliminado'
                ], 403);
            }

            // Verifica si el usuario tiene rol de administrador
            if ($user->role === 'Administrador') {
                // Cuenta cuántos administradores hay
                $totalAdmins = User::where('role', 'Administrador')->count();

                // Si solo hay un administrador, no permitir eliminarlo
                if ($totalAdmins <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se puede eliminar al último administrador.'
                    ]);
                }
            }

            // Elimina el usuario si no es el último administrador
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