<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular; 

class RegistroCombustibleController extends Controller
{
   
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
            'salidas' => 'required',
            'precio' => 'required',
        ]);

        $registrocombustible = new RegistroCombustible();
        $registrocombustible->id_registro_vehicular = $request->input('id_registro_vehicular');
        $registrocombustible->fecha = $request->input('fecha');
        $registrocombustible->num_factura = $request->input('num_factura');
        $registrocombustible->entradas = $request->input('entradas');
        $registrocombustible->salidas = $request->input('salidas');
        $registrocombustible->precio = $request->input('precio');

        $registrocombustible->save();
        
        return redirect()->route('registrocombustible.index');
    }


 
    public function show(string $id) // SOLO QUE MUESTRA UN DATO INDIVIDUAL
    {
        
    }

  
    public function edit(string $id) //MUESTRA DATOS SELECCIONADOS PARA EDITARLO
    {
        
    }


    public function update(Request $request, string $id) // aCTUALIZAR
    {
        
    }


    public function destroy(string $id) 
    {
        //
    }
}
