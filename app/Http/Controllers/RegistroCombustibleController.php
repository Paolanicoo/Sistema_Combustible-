<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular; 
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegistroCombustibleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }
    
    public function index()
    {
        
        $registrocombustible = RegistroCombustible::paginate(10);
        $vehiculos = RegistroVehicular::all();
    
        // Agregar los datos del vehículo a cada registro de combustible
        $registrocombustible->transform(function ($registro) use ($vehiculos) {
            $vehiculo = $vehiculos->firstWhere('id', $registro->id_registro_vehicular);
            $registro->vehiculo = $vehiculo; // Agregamos el vehículo como un atributo adicional
            return $registro;
        });
    
        return view('RegistroCombustible.RCIndex', compact('registrocombustible'));
    }


    public function getTableData(Request $request)
    {
        $combustibles = RegistroCombustible::with('vehiculos')->paginate(10); // Cargar la relación 'vehiculos'

        return response()->json([
            "draw" => $request->input('draw'),
            "recordsTotal" => $combustibles->total(),
            "recordsFiltered" => $combustibles->total(),
            "data" => $combustibles->map(function ($registro) {
                return [
                    'id' => $registro->id,
                    'fecha' => $registro->fecha,
                    'vehiculo_equipo' => $registro->vehiculos->equipo ?? 'N/A',
                    'vehiculo_marca' => $registro->vehiculos->marca ?? 'N/A',
                    'vehiculo_placa' => $registro->vehiculos->placa ?? 'N/A',
                    'vehiculo_asignado' => $registro->vehiculos->asignado ?? 'N/A',
                    'num_factura' => $registro->num_factura,
                    'entradas' => $registro->entradas,
                    'salidas' => $registro->salidas,
                    'acciones' => view('RegistroCombustible.actions', compact('registro'))->render() // Aquí se carga la vista de acciones
                ];
            })
        ]);
    }


    public function create() 
    {
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos
        return view('RegistroCombustible.RCCreate', compact('vehiculos'));
    }

 
    public function store(Request $request) 
    {
       // Validación de los campos en Laravel
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required|exists:registro_vehiculars,id',
            'num_factura' => 'required|string|max:50',
            'entradas' => 'nullable|numeric|min:0',
            'salidas' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
        ], [
            'entradas.numeric' => 'El campo entradas debe ser un número.',
            'salidas.numeric' => 'El campo salidas debe ser un número.',
            'precio.numeric' => 'El campo precio debe ser un número.',
        ]);

    
        try {
            // Crear un nuevo registro de combustible
            $registrocombustible = new RegistroCombustible();
            $registrocombustible->id_registro_vehicular = $request->input('id_registro_vehicular');
            $registrocombustible->fecha = $request->input('fecha');
            $registrocombustible->num_factura = $request->input('num_factura');
            $registrocombustible->entradas = $request->input('entradas') ?: null;
            $registrocombustible->salidas = $request->input('salidas') ?: null;
            $registrocombustible->precio = $request->input('precio');

            // Guardar el nuevo registro
            $registrocombustible->save();
    
            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Nuevo registro creado con éxito!');
    
            // Redirigir a la vista de la lista de registros (solo en éxito)
            return redirect()->route('registrocombustible.index');
    
        } catch (\Exception $e) {
            // Si algo falla, mostrar el error
            Alert::error('Error', 'Hubo un problema al crear el registro. Inténtalo de nuevo.');
    
            // Volver a la vista del formulario con los errores
            return back();  // 'back()' asegura que regrese a la misma página
        }
    
    }
    

    public function show(string $id) // SOLO QUE MUESTRA UN DATO INDIVIDUAL
    {
        
    }

  
    public function edit($id)
    {
        $registro = RegistroCombustible::findOrFail($id);
        $vehiculos = RegistroVehicular::all(); // Obtiene todos los vehículos para el select

        return view('registrocombustible.RCEdit', compact('registro', 'vehiculos'));
    }


    public function destroy(string $id)
    {
        try {
            // Buscar el registro y eliminarlo
            $registro = RegistroCombustible::findOrFail($id);
            $registro->delete();

            // Respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            // Respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }



}