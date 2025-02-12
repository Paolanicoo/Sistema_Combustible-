<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible; 

class RegistroCombustibleController extends Controller
{
   
    public function index() // MOSTRA TODOS LOS DATOS
    {
        $registrocombustible = RegistroCombustible::paginate(10); // este es el numero de datos que va a reflejar
        return view('RegistroCombustible.RCIndex')->with('registrocombustibles',$registrocombustible);
    }

   
    public function create() // SOLO ES UBA VISTA O FORMULARIO
    {
        return view('RegistroCombustible.RCCreate');
    }

 
    public function store(Request $request) // VAN VALIACIONES Y GUARDA
    {
        $request->validate ([
            //aqui colocamos solo valores necesarios para validar no poner letras donde van numeros y asi
           'fecha'=>'required',
            'equipo'=>'required',
            'marca' =>'required',
            'placa'=>'required',
            'asignado'=>'required',
            'numfac'=>'required',
            'engalones'=>'',
            'sagalones'=>'required',
        ]);

        $registrocombustible = new RegistroCombustible();
        $registrocombustible->fecha= $request->input('fecha');
        $registrocombustible->equipo= $request->input('equipo');
        $registrocombustible->marca= $request->input('marca');
        $registrocombustible->placa= $request->input('placa');
        $registrocombustible->asignado= $request->input('asignado');
        $registrocombustible->numfac= $request->input('numfac');
        $registrocombustible->engalones= $request->input('engalones');
        $registrocombustible->sagalones= $request->input('sagalones');


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
