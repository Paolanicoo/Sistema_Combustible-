<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Añadir al inicio del controlador

use App\Models\Combustible;
use App\Models\HistorialCombustible;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventarioCombustibleController extends Controller
{
    public function create()
    {
        return view('InventarioCombustible.create');
    }


    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'cantidad_entrada' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255'
        ]);

        try {
            // Guardamos tanto la entrada como la cantidad actual (que al inicio son iguales)
            Combustible::create([
                'cantidad_entrada' => $request->cantidad_entrada,
                'cantidad_actual' => $request->cantidad_entrada, // Mismo valor al crear
                'descripcion' => $request->descripcion
            ]);

            // SweetAlert para éxito
            Alert::success('Éxito', 'Entrada de combustible creada');

            return redirect()->route('combus.index');
        } catch (\Exception $e) {
            // Manejo de errores y SweetAlert para fallos
            \Log::error('Error al crear entrada de combustible: ' . $e->getMessage());
            Alert::error('Error', 'Hubo un problema: ' . $e->getMessage());

            return back();
        }
    }


    public function edit($id)
    {
        $combustible = Combustible::findOrFail($id);
        return view('InventarioCombustible.edit', compact('combustible'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'cantidad_retirada' => 'required|numeric|min:0.01',
        'persona' => 'required|string|max:100',
        'fecha' => 'required|date'
    ]);

    $combustible = Combustible::findOrFail($id);
    
    if($request->cantidad_retirada > $combustible->cantidad_actual) {
        Alert::error('Error', 'No hay suficiente combustible disponible');
        return back();
    }

    // Actualizar solo la cantidad actual
    $nueva_cantidad = $combustible->cantidad_actual - $request->cantidad_retirada;
    $combustible->update(['cantidad_actual' => $nueva_cantidad]);

    // Registrar en historial
    HistorialCombustible::create([
        'combustible_id' => $id,
        'cantidad_retirada' => $request->cantidad_retirada,
        'cantidad_restante' => $nueva_cantidad,
        'persona' => $request->persona,
        'fecha' => $request->fecha,
        'observacion' => $request->observacion
    ]);

    Alert::success('Éxito', 'Salida registrada y combustible actualizado');
    return redirect()->route('combus.index');
}

    public function show($id)
    {
        $combustible = Combustible::with('historial')->findOrFail($id);
        return view('InventarioCombustible.show', compact('combustible'));
    }

    public function index()
{
    // Ordena los registros de combustible por la columna created_at en orden descendente
    $combustibles = Combustible::orderBy('created_at', 'desc')->paginate(10);
    
    return view('InventarioCombustible.index', compact('combustibles'));
}


    public function destroy($id)
{
    try {
        DB::beginTransaction();
        
        // 1. Eliminar primero el historial relacionado
        HistorialCombustible::where('combustible_id', $id)->delete();
        
        // 2. Eliminar el registro principal
        Combustible::findOrFail($id)->delete();
        
        DB::commit();
        
        Alert::success('Éxito', 'Registro de combustible eliminado correctamente');
        return redirect()->route('combus.index');
        
    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error('Error', 'No se pudo eliminar: ' . $e->getMessage());
        return back();
    }
}

    
}