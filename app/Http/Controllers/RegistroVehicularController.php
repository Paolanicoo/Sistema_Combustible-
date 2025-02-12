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
        $request->validate ([
            //aqui colocamos solo valores necesarios para validar no poner letras donde van numeros y asi
            'equipo'=>'required',
            'marca' =>'required',
            'placa'=>'required',
            'motor'=>'required',
            'modelo'=>'required',
            'serie'=>'required',
            'asignado'=>'required',

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
        return redirect()->route('registrovehicular.index');
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
