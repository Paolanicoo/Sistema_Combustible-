<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroRol;
use Illuminate\Support\Facades\Auth;

class RegistroRolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }

    public function getData(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'Administrador') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($request->ajax()) {
            $roles = RegistroRol::select('id', 'rol', 'estado')->get()->map(function ($role) {
                $role->estado_texto = $role->estado ? '<span class="badge bg-success">Activo</span>' 
                                                    : '<span class="badge bg-danger">Inactivo</span>';
                return $role;
            });

            return datatables()->of($roles)
                ->addColumn('acciones', function ($role) {
                    // Cambiamos el ícono a pleca y X
                    $btnClass = $role->estado ? 'btn-danger' : 'btn-success';
                    $iconClass = $role->estado ? 'fa-times text-white' : 'fa-check text-white';

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

        return view('RegistroRol.RRCreate');
    }

    // 🛠 MÉTODO PARA MOSTRAR FORMULARIO DE EDICIÓN
        public function edit($id)
    {
        if (!Auth::user() || Auth::user()->role !== 'Administrador') {
            return abort(403, "No tienes permisos para editar roles.");
        }

        $role = RegistroRol::find($id);

        if (!$role) {
            return abort(404, "Rol no encontrado");
        }

        return view('RegistroRol.REEditarRol', compact('role'));
    }


    //  MÉTODO PARA ACTUALIZAR EL ROL
    public function update(Request $request, $id)
    {
            // Validar que el campo estado venga correctamente
            $request->validate([
                'estado' => 'required|in:1,0',
                'rol' => 'required|string'
            ]);
        
            // Buscar el registro en RegistroRol, no en User
            $role = RegistroRol::find($id);
        
            if (!$role) {
                return back()->withErrors(['error' => 'Rol no encontrado.']);
            }
        
            // Si es el rol "Administrador" y se intenta desactivar, prevenirlo
            if ($role->rol === 'Administrador' && $request->estado == 0) {
                return back()->withErrors(['error' => 'No puedes desactivar al Administrador.']);
            }
        
            // Actualizar los valores correctamente en la tabla registro_rols
            $role->update([
                'rol' => $request->rol,
                'estado' => $request->estado
            ]);
        
            return redirect()->route('registrorol.table')->with('success', 'Rol actualizado correctamente.');
        
    }
    public function toggleEstado(Request $request)
    {
        $role = RegistroRol::findOrFail($request->id);

        // Prevenir desactivar el Administrador
        if ($role->rol === 'Administrador' && $request->estado == 0) {
            return response()->json(['success' => false, 'message' => 'No puedes desactivar al Administrador.']);
        }

        $role->estado = $request->estado;
        $role->save();

        return response()->json(['success' => true]);
    }



}
