<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResumenImporte;

class ResumenImporteController extends Controller
{
    
    public function index()
    {
       
        $registroimporte = ResumenImporte::paginate(10); // este es el numero de datos que va a reflejar
        return view('RegistroImporte.RIIndex')->with('resumenimportes',$registroimporte);
    }


    public function create()
    {
        return view('RegistroImporte.RICreate');
    }

   
    public function store(Request $request)
    {
        $request->validate ([
            //aqui colocamos solo valores necesarios para validar no poner letras donde van numeros y asi
            //'mes'=>'required',
            'fecha' =>'required',
            'equipo' =>'required',
            'marca'=>'required',
            'placa'=>'required',
            'asignado'=>'required',
            'numfac'=>'required',
            'consumo'=>'required',
            'precio'=>'required',
            'total'=>'required',
            'empresa'=>'required'
        ]);


        $registroimporte = new ResumenImporte();
        //$registroimporte->mes= $request->input('mes');
        $registroimporte->fecha= $request->input('fecha');
        $registroimporte->equipo= $request->input('equipo');
        $registroimporte->marca= $request->input('marca');
        $registroimporte->placa= $request->input('placa');
        $registroimporte->asignado= $request->input('asignado');
        $registroimporte->numfac= $request->input('numfac');
        $registroimporte->consumo= $request->input('consumo');
        $registroimporte->precio= $request->input('precio');
        $registroimporte->total= $request->input('total');
        $registroimporte->empresa= $request->input('empresa');
        $registroimporte->costo= $request->input('costo');
        $registroimporte->gasto= $request->input('gasto');


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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
