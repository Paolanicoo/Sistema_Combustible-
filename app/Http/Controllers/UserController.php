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
        $usuarios = User::select('id', 'name', 'role')->get();
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
                'nombre' => 'required|string|max:255', 
                'rol' => 'required|string|in:Administrador,Usuario,Visualizador',
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

             // Guardar usuario correctamente
            $user = new User();
            $user->name = $request->nombre; // Asegúrate de que el nombre coincide con el formulario
            $user->role = $request->rol;
            $user->password = bcrypt($request->password);
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

        return view('User.RUEdit', compact('usuario')); // Retornar la vista con el usuario
    } catch (\Exception $e) {
        \Log::error('Error al buscar usuario: ' . $e->getMessage());

        return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
    }
}


    public function actualizar($id) {
        try {
            $usuario = User::findOrFail($id);
            return view('User.RUEdit', compact('usuario'));
        } catch (\Exception $e) {
            \Log::error('Error al buscar usuario: ' . $e->getMessage());
            
            // Si la solicitud es AJAX, responder con JSON
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
    
            return redirect()->route('user.index')->with('error', 'Usuario no encontrado');
        }
    }
    

    public function update(Request $request, $id) {
        try {
            $usuario = User::findOrFail($id);
    
            // Validación de datos
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:users,name,' . $id, // Verifica que el nombre sea único excepto para el usuario actual
                'rol' => 'required|string|in:Administrador,Usuario,Visualizador',
                'password' => 'nullable|min:6|confirmed', // La contraseña es opcional, pero si se proporciona, debe ser confirmada
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
    
            // Actualizar datos del usuario
            $usuario->name = $request->nombre;
            $usuario->role = $request->rol;
    
            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
            }
    
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
