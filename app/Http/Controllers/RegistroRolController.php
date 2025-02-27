<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroRol; 
use Illuminate\Support\Facades\Auth;

class RegistroRolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }

    public function getData(Request $request)
    {    
        if ($request->ajax()) {
            // Aquí puedes recuperar los roles desde la base de datos
            $rols = RegistroRol::select('id', 'rol')->get();
            return datatables()->of($rols)->toJson();
         }

            return view('RegistroRol.RRCreate'); // En caso de no ser una solicitud AJAX

    }
    /**
     * RegistroRol.RRCreate
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
