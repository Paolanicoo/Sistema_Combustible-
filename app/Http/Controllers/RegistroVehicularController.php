<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroVehicular; 
use App\Models\HistorialAsignacion; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RegistroVehicularController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }
    
    public function index()
    {
        
        $registros = RegistroVehicular::paginate(10); // Obtener registros con paginación
        return view('RegistroVehicular.RVIndex', compact('registros'));


    }

    // Método para obtener los registros en formato JSON
    public function getTableData()
    {
        $registros = RegistroVehicular::all(); // o usa paginación si lo prefieres
        return datatables()->of($registros)
            ->addColumn('acciones', function ($registro) {
                return view('RegistroVehicular.actions', compact('registro')); // Esta línea devuelve la vista de las acciones
            })
            ->make(true);
    }

    public function create()
    {
        return view('RegistroVehicular.RVCreate');
    }

    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'equipo'    => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z\s]+$/'],
            'marca'     => ['nullable', 'string', 'max:25', 'regex:/^[a-zA-Z\s]+$/'],
            'placa'     => ['nullable', 'string', 'regex:/^[A-Z]{3} \d{4}$/', 'max:8', 'unique:registro_vehiculars,placa'],
            'motor'     => 'nullable|string|max:35',
            'modelo'    => 'nullable|string|max:30',
            'serie'     => 'nullable|string|max:25',
            'asignado'  => 'required|string|max:30',
            'observacion' => 'nullable|string|max:40',
        ], [
            'placa.unique' => 'La placa ya está registrada.',
            'equipo.required' => 'El equipo es obligatorio.',
            'asignado.required' => 'El asignado es obligatorio.',
        ]);

        try {
            // Crear y guardar el registro vehicular
            $registrovehicular = RegistroVehicular::create([
                'equipo' => $request->equipo,
                'marca' => $request->marca,
                'placa' => $request->placa,
                'motor' => $request->motor,
                'modelo' => $request->modelo,
                'serie' => $request->serie,
                'asignado' => $request->asignado,
                'observacion' => $request->observacion
            ]);

            // Crear el historial de asignación
            HistorialAsignacion::create([
                'registro_vehicular_id' => $registrovehicular->id,
                'asignado' => $request->asignado
            ]);

            Alert::success('Éxito', '¡Nuevo registro creado con éxito!');
            return redirect()->route('registrovehicular.index');

        } catch (\Exception $e) {
            \Log::error('Error al crear registro: ' . $e->getMessage());
            Alert::error('Error', 'Hubo un problema: ' . $e->getMessage());
            return back();
        }
    }
    

    public function show($id)
    {
        // Obtener el vehículo por su ID
        $registro = RegistroVehicular::findOrFail($id);

        // Obtener el historial de asignaciones (si existe)
        $historialAsignaciones = \DB::table('historial_asignaciones')
                                    ->where('registro_vehicular_id', $id)
                                    ->get();

        // Retornar la vista con el vehículo y el historial de asignaciones
        return view('RegistroVehicular.RVShow', compact('registro', 'historialAsignaciones'));
    }


    public function edit($id)
    {
        $registro = RegistroVehicular::findOrFail($id);
        return view('registrovehicular.RVEdit', compact('registro')); // Envía la variable a la vista
    }
    
    public function update(Request $request, $id)
    {
        $registro = RegistroVehicular::findOrFail($id);
        
        $request->validate([
            'equipo'    => ['required', 'max:20', 'regex:/^[a-zA-Z\s]+$/'],
            'placa'     => 'nullable|max:10|unique:registro_vehiculars,placa,' . $id,
            'motor'     => 'nullable|max:35',
            'marca'     => 'nullable|max:25',
            'modelo'    => 'nullable|max:30',
            'serie'     => 'nullable|max:25',
            'asignado'  => 'required|max:30',
            'observacion' => 'nullable|max:40',
        ], [
            'placa.unique' => 'La placa ya está registrada.',
            'equipo.required' => 'El equipo es obligatorio.',
            'asignado.required' => 'El asignado es obligatorio.',
        ]);

        // Comparar los datos existentes con los nuevos
        $datosOriginales = $registro->getOriginal();
        $datosNuevos = $request->all();

        // Filtrar para quitar campos nulos o vacíos
        $datosNuevos = array_filter($datosNuevos, function($value) {
            return $value !== null && $value !== '';
        });

        // Verificar si hay cambios
        $hayCambios = false;
        foreach ($datosNuevos as $key => $value) {
            if ($key != '_token' && 
                isset($datosOriginales[$key]) && 
                $datosOriginales[$key] != $value) {
                $hayCambios = true;
                break;
            }
        }

        // Si no hay cambios, redirigir sin actualizar
        if (!$hayCambios) {
            Alert::info('Sin cambios', 'No se detectaron modificaciones.');
            return redirect()->route('registrovehicular.index');
        }

        try {
            // Actualizar el registro
            $registro->update($datosNuevos);

            Alert::success('Éxito', '¡Registro actualizado correctamente!');
            return redirect()->route('registrovehicular.index');

        } catch (\Exception $e) {
            \Log::error('Error en update: ' . $e->getMessage());
            Alert::error('Error', 'Hubo un problema: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($id){
        $registro = RegistroVehicular::find($id);

        if (!$registro) {
            return response()->json(['success' => false, 'message' => 'Registro no encontrado']);
        }

        // Verificar si el vehículo está en uso en la tabla `resumen_importes`
        $enUso = \DB::table('resumen_importes')->where('id_registro_vehicular', $id)->exists();

        if ($enUso) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar el vehículo porque está en uso.']);
        }

        $registro->delete();

        return response()->json(['success' => true, 'message' => 'Registro eliminado correctamente']);
    }
}