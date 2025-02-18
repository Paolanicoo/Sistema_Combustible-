<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResumenImporte;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;

class ResumenImporteController extends Controller
{
    
    public function index()
{
    $registroimporte = ResumenImporte::paginate(10);
    $vehiculos = RegistroVehicular::all();
    $combustibles = RegistroCombustible::all();

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
            
            'precio'=>'required',
            'total'=>'required',
            'empresa'=>'required',
            'cog'=>'required'
        ]);


        $registroimporte = new ResumenImporte();
        $registroimporte->id_registro_vehicular = $request->input('id_registro_vehicular');
        $registroimporte->id_registro_combustible = $request->input('id_registro_combustible');
        $registroimporte->total= $request->input('total');
        $registroimporte->empresa= $request->input('empresa');
        $registroimporte->cog= $request->input('cog');
        


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
    $vehiculos = RegistroVehicular::all(); // Asegúrate de obtener todos los vehículos
    $combustibles = RegistroCombustible::all(); 

    return view('registroimporte.RIEdit', compact('registro', 'vehiculos','combustibles'));

   
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'fecha' => 'date',
        'id_registro_vehicular' => 'required',
        'id_registro_combustible' => 'required',
        'total' => 'numeric',
        'empresa' => 'required|string',
        'cog' => 'required|string',
        
    ]);

    // Verificar qué datos se están enviando
    

    $registro = ResumenImporte::findOrFail($id);
    $registro->update([
        'fecha' => $request->fecha,
        'id_registro_vehicular' => $request->id_registro_vehicular,
        'id_registro_combustible' => $request->id_registro_combustible,
        'total' => $request->salidas * $request->precio, // Calculamos el total
        'empresa'=> $request->empresa,
        'cog' => $request->cog,
        'precio' => $request->precio,
        
    ]);

    return redirect()->route('registroimporte.index')->with('success', 'Registro actualizado correctamente');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
