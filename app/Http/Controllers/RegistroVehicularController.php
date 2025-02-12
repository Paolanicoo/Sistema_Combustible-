<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroVehicular; 

class RegistroVehicularController extends Controller
{
    
    public function index()
    {
        $registrovehicular = RegistroVehicular::paginate(10); // este es el numero de datos que va a reflejar
        return view('RegistroVehicular.RVIndex')->with('registrovehiculars',$registrovehicular);
    }
  
    public function create()
    {
        return view('RegistroVehicular.RVCreate');
    }

    public function store(Request $request) //validaciones
    {
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
    

        $registrovehicular = new RegistroVehicular();
        $registrovehicular->equipo= $request->input('equipo');
        $registrovehicular->marca= $request->input('marca');
        $registrovehicular->placa= $request->input('placa');
        $registrovehicular->motor= $request->input('motor');
        $registrovehicular->modelo= $request->input('modelo');
        $registrovehicular->serie= $request->input('serie');
        $registrovehicular->asignado= $request->input('asignado');
        $registrovehicular->observacion= $request->input('observacion');


        $registrovehicular->save();
        return redirect()->route('registrovehicular.index')->with('success', 'Registro guardado exitosamente');
    

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
