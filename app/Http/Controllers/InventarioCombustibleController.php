<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Añadir al inicio del controlador

use App\Models\Combustible;
use App\Models\HistorialCombustible;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventarioCombustibleController extends Controller
{
    public function getData()
    {
        $combustibles = Combustible::orderBy('created_at', 'desc')->get();

        return datatables()->of($combustibles)
            ->addColumn('acciones', function ($combustible) {
                return '
                    <div class="d-flex justify-content-center gap-2">
                        <a href="'.route('combus.edit', $combustible->id).'" 
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="tooltip"
                        title="Registrar salida">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <a href="'.route('combus.show', $combustible->id).'" 
                        class="btn btn-info btn-sm"
                        data-bs-toggle="tooltip"
                        title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="'.$combustible->id.'" 
                                data-url="'.route('combus.destroy', $combustible->id).'"
                                data-bs-toggle="tooltip"
                                title="Eliminar registro">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['acciones']) // Permitir que las acciones se rendericen como HTML
            ->make(true);
    }


    public function create()
    {
        return view('InventarioCombustible.create');
    }


    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'cantidad_entrada' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:60'
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
            
            // Verificar si el registro existe antes de intentar eliminarlo
            $combustible = Combustible::find($id);
            if (!$combustible) {
                return response()->json([
                    'success' => false,
                    'message' => 'El registro no existe o ya fue eliminado'
                ], 404);
            }

            // 1. Eliminar primero el historial relacionado
            HistorialCombustible::where('combustible_id', $id)->delete();
            
            // 2. Eliminar el registro principal
            $combustible->delete();
            
            DB::commit();

            // Respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            
            // Respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }


}