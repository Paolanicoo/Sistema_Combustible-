<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 

use App\Models\Combustible;
use App\Models\HistorialCombustible;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventarioCombustibleController extends Controller
{
    //La función getData() sirve para obtener y preparar los datos de la tabla combustibles
    public function getData()
    {
        //Obtener todos los registros de la tabla 'combustibles'.
        $combustibles = Combustible::orderBy('created_at', 'desc')->get();

        //Retornar los datos en formato compatible con DataTables.
        return datatables()->of($combustibles)
        //Formatear la columna 'fecha' para que se muestre en formato 'día/mes/año'.
            ->editColumn('fecha', function ($combustible) {
                return date('d/m/Y', strtotime($combustible->fecha));
            })
            //Agregar una nueva columna personalizada llamada 'acciones'.
        // Esta columna contiene botones HTML para editar, ver y eliminar el registro.
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
// Función que muestra el formulario de creación de un nuevo registro de combustible.
    public function create()
    {
         // Retorna la vista ubicada en 'resources/views/InventarioCombustible/create.blade.php'.
         // Esta vista contiene el formulario para registrar un nuevo combustible (entrada al inventario).
        return view('InventarioCombustible.create');
    }

    // Función que se encarga de guardar una nueva entrada de combustible en la base de datos.
    public function store(Request $request)
    {
        // Validación de los campos, incluyendo la fecha
        $request->validate([
            'fecha' => 'required|date',
            'cantidad_entrada' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:100'
        ]);

        try {
            // Guardamos tanto la entrada como la cantidad actual (que al inicio son iguales)
            // y ahora también la fecha seleccionada por el usuario.
            Combustible::create([
                'fecha' => $request->fecha,
                'cantidad_entrada' => $request->cantidad_entrada,
                'cantidad_actual' => $request->cantidad_entrada, 
                'descripcion' => $request->descripcion
            ]);

            // AlertA para éxito
            Alert::success('Éxito', 'Entrada de combustible creada');
            return redirect()->route('combus.index'); // Redirigir al usuario a la vista principal del módulo.

        } catch (\Exception $e) {
            // Manejo de errores y SweetAlert para fallos.
            \Log::error('Error al crear entrada de combustible: ' . $e->getMessage());
             // Mostrar una notificación de error con el mensaje capturado.
            Alert::error('Error', 'Hubo un problema: ' . $e->getMessage());
            // Volver atrás a la vista anterior conservando los datos ingresados.
            return back();
        }
    }

    public function edit($id) // Función que muestra el formulario para editar una entrada de combustible existente
    {
        // Busca el registro de combustible por su ID.
        $combustible = Combustible::findOrFail($id);
        // Retorna la vista 'edit' ubicada en 'resources/views/InventarioCombustible/edit.blade.php'
       // y le pasa el registro de combustible a través de la variable $combustible.
        return view('InventarioCombustible.edit', compact('combustible'));
    }

    // Función que se encarga de registrar una salida de combustible (actualizar la cantidad disponible).
    public function update(Request $request, $id)
    {
         // Validación de los datos del formulario
        $request->validate([
            'cantidad_retirada' => 'required|numeric|min:0.01',
            'persona' => 'required|string|max:30|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'fecha' => 'required|date',
        ], [
            'cantidad_retirada.required' => 'El campo cantidad a retirar es obligatorio.',
            'cantidad_retirada.numeric' => 'Debe ingresar un número válido.',
            'cantidad_retirada.min' => 'Debe ser al menos 0.01 galones.',
        
            'persona.required' => 'El campo persona es obligatorio.',
            'persona.regex' => 'El campo persona solo debe contener letras y espacios.',
            'persona.max' => 'El campo persona no debe exceder los 30 caracteres.',
        
            'fecha.required' => 'El campo fecha es obligatorio.',
            'fecha.date' => 'Debe ingresar una fecha válida.',
        ]);
         // Buscar el registro de combustible por ID.
        $combustible = Combustible::findOrFail($id);
        // Verificar si la cantidad a retirar es mayor a la disponible.
        if($request->cantidad_retirada > $combustible->cantidad_actual) {
            // Mostrar error si no hay suficiente combustible
            Alert::error('Error', 'No hay suficiente combustible disponible');
            return back(); // Volver a la vista anterior
        }

        // Actualizar solo la cantidad actual
        $nueva_cantidad = $combustible->cantidad_actual - $request->cantidad_retirada;
         // Actualizar el registro de combustible con la nueva cantidad disponible
        $combustible->update(['cantidad_actual' => $nueva_cantidad]);

        // Registrar en historial
        HistorialCombustible::create([
            'combustible_id' => $id, // Relación con el registro original.
            'cantidad_retirada' => $request->cantidad_retirada, // Cuánto combustible se retiró.
            'cantidad_restante' => $nueva_cantidad, // Cuánto queda disponible.
            'persona' => $request->persona,  // Quién retiró el combustible.
            'fecha' => $request->fecha,  // Fecha de la salida.
            'observacion' => $request->observacion // Observaciones adicionales (opcional).
        ]);
        // Mostrar mensaje de éxito al usuario.
        Alert::success('Éxito', 'Salida registrada y combustible actualizado');
        return redirect()->route('combus.index'); // Redirigir al usuario a la vista principal del módulo
    }

    // Función que muestra los detalles de un registro específico.
    public function show($id)
    {
        // Busca el registro de combustible por su ID.
        $combustible = Combustible::with('historial')->findOrFail($id);
        return view('InventarioCombustible.show', compact('combustible'));
    }

    // Función que muestra la lista paginada de todos los registros de combustible
    public function index()
    {
        // Obtiene todos los registros ordenados por fecha de creación (más recientes primero)
        // y los pagina de 10 en 10.
        $combustibles = Combustible::orderBy('created_at', 'desc')->paginate(10);
        // Retorna la vista 'index' y le pasa la lista paginada de combustibles
        return view('InventarioCombustible.index', compact('combustibles'));
    }

    // Función que elimina un registro de combustible junto con su historial relacionado.
    public function destroy($id)
    {
        try {
            // Inicia una transacción de base de datos para garantizar que ambas eliminaciones (historial y registro) ocurran correctamente.
            DB::beginTransaction();
            
            // Busca el registro de combustible por ID
            $combustible = Combustible::find($id);
            // Si no existe el registro, retorna una respuesta JSON indicando el error
            if (!$combustible) {
                return response()->json([
                    'success' => false,
                    'message' => 'El registro no existe o ya fue eliminado'
                ], 404); // Código de respuesta 404: No encontrado.
            }

            // Eliminar primero el historial relacionado.
            HistorialCombustible::where('combustible_id', $id)->delete();
            
            //  Eliminar el registro principal.
            $combustible->delete();
             // Confirma (guarda) la transacción.
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