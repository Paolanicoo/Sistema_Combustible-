<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroRol;
use Illuminate\Support\Facades\Auth;

class RegistroRolController extends Controller
{
    // Constructor del controlador.
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }
    // Método para obtener datos para una tabla con AJAX.
    public function getData(Request $request)
    {
         // Verifica si el usuario autenticado tiene el rol de 'Administrador'.
        if (!Auth::user() || Auth::user()->role !== 'Administrador') {
            return response()->json(['error' => 'No autorizado'], 403);
        }
         // Si la petición es AJAX, se procesan los datos para DataTables.
        if ($request->ajax()) {
             // Obtiene los roles y mapea el estado como texto (activo/inactivo).
            $roles = RegistroRol::select('id', 'rol', 'estado')->get()->map(function ($role) {
                $role->estado_texto = $role->estado ? '<span class="badge bg-success">Activo</span>' 
                                                    : '<span class="badge bg-danger">Inactivo</span>';
                return $role;
            });
            // Devuelve la respuesta para DataTables incluyendo columna de acciones.
            return datatables()->of($roles)
                ->addColumn('acciones', function ($role) {
                    // Define clases de botón e ícono según el estado.
                    $btnClass = $role->estado ? 'btn-danger' : 'btn-success';
                    $iconClass = $role->estado ? 'fa-times text-white' : 'fa-check text-white';
                     // Botón para cambiar estado del rol.
                    return '
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-sm toggleEstado ' . $btnClass . '" 
                                    data-id="' . $role->id . '" 
                                    data-estado="' . $role->estado . '">
                                <i class="fas ' . $iconClass . '"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['estado_texto', 'acciones'])
                ->toJson();
        }

        return view('RegistroRol.RRCreate'); //Retorna la vista de creación de roles.
    }

    // Método para mostrar el formulario de edición de roles.
        public function edit($id)
    {
        // Solo permite acceso si el usuario es administrador.
        if (!Auth::user() || Auth::user()->role !== 'Administrador') {
            return abort(403, "No tienes permisos para editar roles.");
        }
         // Busca el rol por su ID.
        $role = RegistroRol::find($id);
        // Si no se encuentra el rol, retorna error 404.
        if (!$role) {
            return abort(404, "Rol no encontrado");
        }
        // Retorna la vista de edición con los datos del rol.
        return view('RegistroRol.REEditarRol', compact('role'));
    }


    // Método para actualizar un rol.
    public function update(Request $request, $id)
    {
            //  // Validación de campos del formulario.
            $request->validate([
                'estado' => 'required|in:1,0',
                'rol' => 'required|string'
            ]);
        
             // Busca el registro del rol por su ID.
            $role = RegistroRol::find($id);
             // Si no se encuentra el rol, redirige con error.
            if (!$role) {
                return back()->withErrors(['error' => 'Rol no encontrado.']);
            }
        
            // No se permite desactivar el rol de Administrador
            if ($role->rol === 'Administrador' && $request->estado == 0) {
                return back()->withErrors(['error' => 'No puedes desactivar al Administrador.']);
            }
        
            // Actualizar los valores correctamente en la tabla registro_rols
            $role->update([
                'rol' => $request->rol,
                'estado' => $request->estado
            ]);
             // Redirige a la tabla con mensaje de éxito.
            return redirect()->route('registrorol.table')->with('success', 'Rol actualizado correctamente.');
        
    }
    //Método para activar/desactivar un rol.
    public function toggleEstado(Request $request)
    {
        // Busca el rol a modificar por su ID.
        $role = RegistroRol::findOrFail($request->id);

        // Prevenir desactivar el Administrador
        if ($role->rol === 'Administrador' && $request->estado == 0) {
            return response()->json(['success' => false, 'message' => 'No puedes desactivar al Administrador.']);
        }
        // Actualiza el estado del rol (activo/inactivo).
        $role->estado = $request->estado;
        $role->save();
        // Retorna respuesta JSON de éxito
        return response()->json(['success' => true]);
    }



}
