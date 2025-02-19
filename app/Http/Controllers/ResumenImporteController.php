<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResumenImporte;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;

class ResumenImporteController extends Controller
{
    
    public function index(Request $request)
{
    $registroimporte = ResumenImporte::paginate(10);
    $vehiculos = RegistroVehicular::all();
    $combustibles = RegistroCombustible::all();

    $query = ResumenImporte::query();

    // Obtener los filtros de búsqueda
    $equipo = $request->input('equipo');
    $asignado = $request->input('asignado');
    $mes = $request->input('mes');

    // Query base
    $query = ResumenImporte::with(['vehiculo', 'combustible']);

    // Aplicar filtros si existen
    if ($equipo) {
        $query->whereHas('vehiculo', function ($q) use ($equipo) {
            $q->where('equipo', 'LIKE', "%$equipo%");
        });
    }

    if ($asignado) {
        $query->whereHas('vehiculo', function ($q) use ($asignado) {
            $q->where('asignado', 'LIKE', "%$asignado%");
        });
    }

    if ($mes) {
        $query->whereMonth('fecha', $mes);
    }
    // Obtener resultados paginados
    $registroimporte = $query->paginate(10);



    // Agregar los datos del vehículo a cada registro de combustible
    $registroimporte->transform(function ($registro) use ($vehiculos, $combustibles) {
        $vehiculo = $vehiculos->firstWhere('id', $registro->id_registro_vehicular);
        $combustible = $combustibles->firstWhere('id', $registro->id_registro_combustible);

        // Agregar datos relacionados
        $registro->vehiculo = $vehiculo;
        $registro->combustible = $combustible;

        // Calcular el total
        if ($combustible) {
            $registro->total = $combustible->salidas * $combustible->precio;
        } else {
            $registro->total = 0;
        }

        return $registro;
    });

    return view('RegistroImporte.RIIndex', compact('registroimporte', 'combustibles', 'vehiculos'));
}
 


    public function create()
    {
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos
    $combustibles = RegistroCombustible::all(); // Obtener todos los registros de combustible
    
    return view('RegistroImporte.RICreate', compact('vehiculos', 'combustibles'));
    }

   
    public function store(Request $request)
    {
        $request->validate ([
            //aqui colocamos solo valores requeridos
            'fecha'=>'required',
            'precio'=>'required',
            'total'=>'required',
            'empresa'=>'required',
            'cog'=>'required'
        ]);


        $consumo = $request->input('entradas') > 0 ? $request->input('entradas') : $request->input('salidas');
$precio = $request->input('precio');
$total = $consumo * $precio; //  Calcular correctamente el total

$registroimporte = new ResumenImporte();
$registroimporte->fecha = $request->input('fecha');
$registroimporte->id_registro_vehicular = $request->input('id_registro_vehicular');
$registroimporte->id_registro_combustible = $request->input('id_registro_combustible');
$registroimporte->total = $total; //  Guardar el total correctamente
$registroimporte->empresa = $request->input('empresa');
$registroimporte->cog = $request->input('cog');
        


        $registroimporte->save();
        return redirect()->route('registroimporte.index');





    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit($id)
    {
        $registro = ResumenImporte::findOrFail($id);
        $vehiculos = RegistroVehicular::all();
        $combustibles = RegistroCombustible::all();

        return view('registroimporte.RIEdit', compact('registro', 'vehiculos', 'combustibles'));
    }

    /**
     * Actualiza el registro en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required',
            'id_registro_combustible' => 'required',
            'empresa' => 'required|string',
            'cog' => 'required|string',
            'precio' => 'nullable|numeric',
        ]);

        // Obtener el registro de combustible asociado
        $combustible = RegistroCombustible::findOrFail($request->id_registro_combustible);

        // Determinar el consumo (salidas o entradas)
        $consumo = $combustible->salidas > 0 ? $combustible->salidas : $combustible->entradas;

        // Calcular el total de la compra
        $total = $consumo * ($request->precio ?? $combustible->precio);

        // Actualizar el registro
        $registro = ResumenImporte::findOrFail($id);
        $registro->update([
            'fecha' => $request->fecha,
            'id_registro_vehicular' => $request->id_registro_vehicular,
            'id_registro_combustible' => $request->id_registro_combustible,
            'total' => $total,
            'empresa' => $request->empresa,
            'cog' => $request->cog,
            'precio' => $request->precio ?? $combustible->precio,
        ]);

        return redirect()->route('registroimporte.index')->with('success', 'Registro actualizado correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Eliminar registro
        $registro = ResumenImporte::findOrFail($id);
    $registro->delete();

    return redirect()->route('registroimporte.index')->with('success', 'Registro eliminado correctamente');
    }
}
