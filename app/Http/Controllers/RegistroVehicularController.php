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
        'marca'     => ['required', 'string', 'max:25', 'regex:/^[a-zA-Z\s]+$/'],
        'placa'     => ['required', 'string', 'regex:/^[A-Z]{3} \d{4}$/', 'max:8', 'unique:registro_vehiculars,placa'],
        'motor'     => 'required|string|max:35',
        'modelo'    => 'required|string|max:30',
        'serie'     => 'required|string|max:25',
        'asignado'  => 'required|string|max:30',
        'observacion' => 'nullable|string|max:40',
    ], [
        'placa.regex' => 'El formato de la placa debe ser 3 letras mayúsculas seguidas de un espacio y 4 números (Ej: ABC 1234).',
        'placa.unique' => 'La placa ya está registrada.',
        'required' => 'El campo :attribute es obligatorio.',
        'max' => 'El campo :attribute no puede superar los :max caracteres.',
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
        // Validación de los campos con la regla unique para la placa
        $request->validate([
            'equipo'    => 'required|max:20',
            'placa'     => 'required|max:10|unique:registro_vehiculars,placa,' . $id, // Evita que se valide la placa del propio registro
            'motor'     => 'required|max:35',
            'marca'     => 'required|max:25',
            'modelo'    => 'required|max:30',
            'serie'     => 'required|max:25',
            'asignado'  => 'required|max:30',
            'observacion' => 'nullable|max:40',
        ], [
            'placa.regex' => 'El formato de la placa debe ser 3 letras mayúsculas seguidas de un espacio y 4 números (Ej: ABC 1234).',
            'placa.unique' => 'La placa ya está registrada.',
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no puede superar los :max caracteres.',
        ]);

        try {
            // Buscar el registro por ID
            $registro = RegistroVehicular::findOrFail($id);

            // Actualizar los datos del registro
            $registro->update($request->all());

            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Registro actualizado correctamente!');

        } catch (\Exception $e) {
            // Mostrar mensaje de error con SweetAlert si ocurre un problema
            Alert::error('Error', 'Hubo un problema al actualizar el registro.');
        }

        // Redirigir a la vista de lista de registros
        return redirect()->route('registrovehicular.index');
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