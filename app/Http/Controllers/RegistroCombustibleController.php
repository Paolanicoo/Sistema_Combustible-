<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular; 
use Illuminate\Support\Facades\Auth;

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
        $combustibles = RegistroCombustible::with('vehiculos')->paginate(10); // Cargar la relación 'vehiculo'

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
                    'acciones' => 'acciones' // Esto lo manejas en el frontend
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
        $request->validate([
            'fecha' => 'required',
            'id_registro_vehicular' => 'required',
            'num_factura' => 'required',
            'entradas' => 'nullable',
            'salidas' => 'nullable',
            'precio' => 'required',
        ]);

        $registrocombustible = new RegistroCombustible();
        $registrocombustible->id_registro_vehicular = $request->input('id_registro_vehicular');
        $registrocombustible->fecha = $request->input('fecha');
        $registrocombustible->num_factura = $request->input('num_factura');
        $registrocombustible->entradas = $request->input('entradas')?: null;
        $registrocombustible->salidas = $request->input('salidas')?: null;
        $registrocombustible->precio = $request->input('precio');

        $registrocombustible->save();
        
        return redirect()->route('registrocombustible.index');
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

public function update(Request $request, $id)
{
    $registro = RegistroCombustible::findOrFail($id);

    // Intenta asignar y guardar manualmente
    $registro->num_factura = $request->num_factura;
    $registro->save();

    return redirect()->route('registrocombustible.index')->with('success', 'Registro actualizado correctamente');
    $request->validate([
        'fecha' => 'required|date',
        'id_registro_vehicular' => 'required',
        'num_factura' => 'required|numeric',
        'entradas' => 'nullable|numeric',
        'salidas' => 'nullable|numeric',
        'precio' => 'required|numeric',
    ]);

    // Verificar qué datos se están enviando
    

    $registro = RegistroCombustible::findOrFail($id);
    $registro->update([
        'fecha' => $request->fecha,
        'id_registro_vehicular' => $request->id_registro_vehicular,
        'num_factura' => $request->num_factura,
        'entradas' => $request->entradas,
        'salidas' => $request->salidas,
        'precio' => $request->precio,
    ]);

    return redirect()->route('registrocombustible.index')->with('success', 'Registro actualizado correctamente');
}



    public function destroy(string $id) 
    {
        $registro = RegistroCombustible::findOrFail($id);
    $registro->delete();

    return redirect()->route('registrocombustible.index')->with('success', 'Registro eliminado correctamente');
        
    }
}