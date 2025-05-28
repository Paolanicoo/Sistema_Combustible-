<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular; 
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegistroCombustibleController extends Controller
{
    // Constructor del controlador: se ejecuta automáticamente cuando se instancia el controlador.
    public function __construct()
    {
        // Aplica el middleware 'auth' a todas las funciones del controlador.
        // Esto significa que solo los usuarios autenticados podrán acceder a las rutas controladas por este controlador.
        $this->middleware('auth'); 
    }
    //Función para ver todos los registros
    public function index()
    {
        // Obtiene todos los registros ordenados por fecha de creación (más recientes primero).
        // y los pagina de 10 en 10.
        $registrocombustible = RegistroCombustible::paginate(10);
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos.
    
        // Agregar los datos del vehículo a cada registro de combustible.
        $registrocombustible->transform(function ($registro) use ($vehiculos) {
            $vehiculo = $vehiculos->firstWhere('id', $registro->id_registro_vehicular);
            $registro->vehiculo = $vehiculo; // Agregamos el vehículo como un atributo adicional.
            return $registro; // Retorna el registro modificado para que quede actualizado en la colección.
        });

        // Retorna la vista 'RCIndex' dentro de la carpeta 'RegistroCombustible',
       // pasando la variable $registrocombustible para que esté disponible en la vista
        return view('RegistroCombustible.RCIndex', compact('registrocombustible'));
    }

    //Obtiene los datos para ser mostrados en una tabla dinámica (como DataTables).
    public function getTableData(Request $request)
    {
        try {
             // Inicia la consulta con el modelo RegistroCombustible y carga la relación 'vehiculos'.
            $query = RegistroCombustible::with('vehiculos');
            
            // Obtener total de registros sin filtrar.
            $recordsTotal = $query->count();
            
            // Aplicar búsqueda global si existe.
            if ($request->has('search') && !empty($request->input('search.value'))) {
                // Obtiene el valor de búsqueda.
                $searchValue = $request->input('search.value');
                // Aplica un filtro a la consulta principal usando un closure para agrupar condiciones.
                $query->where(function($q) use ($searchValue) {
                    $q->where('fecha', 'like', "%{$searchValue}%")
                    ->orWhere('num_factura', 'like', "%{$searchValue}%")
                    ->orWhereHas('vehiculos', function($subQuery) use ($searchValue) {
                        $subQuery->where('equipo', 'like', "%{$searchValue}%")
                                ->orWhere('marca', 'like', "%{$searchValue}%")
                                ->orWhere('placa', 'like', "%{$searchValue}%")
                                ->orWhere('asignado', 'like', "%{$searchValue}%");
                    });
                });
            }
            
            // Obtener total de registros después del filtrado.
            $recordsFiltered = $query->count();
            
            
            // Ordenar resultados - manejo simplificado para evitar errores.
            if ($request->has('order') && $request->input('order.0.column') !== null) {
                // Se obtiene el índice de la columna por la cual se va a ordenar.
                $columnIndex = $request->input('order.0.column');
                 // A partir del índice, se recupera el nombre de la columna.
                $columnName = $request->input("columns.{$columnIndex}.data");
                 // Dirección de ordenamiento: 'asc' o 'desc'; por defecto se usa 'asc'.
                $columnDirection = $request->input('order.0.dir', 'asc');
                
                // Manejar ordenamiento de columnas básicas o por defecto.
                if (in_array($columnName, ['fecha', 'num_factura', 'entradas', 'salidas'])) {
                    $query->orderBy($columnName, $columnDirection); // Aplica el ordenamiento a la consulta.
                }
                
            } else {
                // Ordenamiento por defecto si no se especifica.
                $query->orderBy('fecha', 'desc');
            }
            
            
            //Paginación de registros 10 en 10.
            $start = $request->input('start', 0);
            // Se obtiene la cantidad de registros por página desde la petición o se usa 10.
            $length = $request->input('length', 10);
            // Se aplica la paginación a la consulta usando skip y take.
            $combustibles = $query->skip($start)->take($length)->get();
            // Se transforma el resultado para que coincida con el formato esperado por DataTables.
            $data = $combustibles->map(function ($registro) {
                // Convertir entradas de litros a galones.
                $entradasGalones = $registro->entradas;

                 // Retornamos un arreglo con los campos formateados
                return [
                    'id' => $registro->id,
                    'fecha' => $registro->fecha,
                    'vehiculo_equipo' => $registro->vehiculos->equipo ?? 'N/A', // Equipo del vehículo relacionado.
                    'vehiculo_marca' => $registro->vehiculos->marca ?? null,  // Marca del vehículo.
                    'vehiculo_placa' => $registro->vehiculos->placa ?? null, // Placa del vehículo.
                    'vehiculo_asignado' => $registro->vehiculos->asignado ?? 'N/A', // Persona a quien se asignó el vehículo.
                    'num_factura' => $registro->num_factura, // Número de factura.
                    'entradas' => $entradasGalones, // Cantidad de entrada (galones).
                    'salidas' => number_format($registro->salidas, 2, '.', ''),  // Salidas formateadas con 2 decimales.
                    'observacion' => $registro->observacion, // Observaciones adicionales.
                    'acciones' => view('RegistroCombustible.actions', compact('registro'))->render() // Vista parcial con botones de acción
                ];
            });
            // Devuelve la respuesta en formato JSON, como espera DataTables.
            return response()->json([
                "draw" => intval($request->input('draw', 1)),  // Parámetro de control para DataTables.
                "recordsTotal" => $recordsTotal,  // Total de registros sin filtros.
                "recordsFiltered" => $recordsFiltered, // Total de registros después de aplicar filtros.
                "data" => $data // Los datos ya formateados para la tabla.
            ]);
            
        } catch (\Exception $e) {
             // En caso de error, se registra el mensaje en los logs.
            \Log::error('Error en DataTables: ' . $e->getMessage());
             // Se devuelve una respuesta de error con los campos esperados por DataTables.
            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => "Error al procesar los datos: " . $e->getMessage()
            ]);
        }
    }

    // Función que muestra el formulario de creación de un nuevo registro de combustible.
    public function create() 
    {
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos
        return view('RegistroCombustible.RCCreate', compact('vehiculos'));
    }

    // Función que se encarga de guardar un nuevo registro de combustible en la base de datos.
    public function store(Request $request) 
    {
       // Validación de los campos en Laravel
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required|exists:registro_vehiculars,id',
            'num_factura' => 'required|string|max:10',
            'tipo' => 'required|in:galones,litros', 
            'entradas' => 'nullable|numeric|min:0',
            'salidas' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'observacion' => 'nullable|string|max:40',
        ], [
            'tipo.required' => 'Debe seleccionar un tipo de medida.',
            'tipo.in' => 'El tipo de medida debe ser galones o litros.',
            'entradas.numeric' => 'El campo entradas debe ser un número.',
            'salidas.numeric' => 'El campo salidas debe ser un número.',
            'precio.numeric' => 'El campo precio debe ser un número.',
            'fecha.required' => 'El campo "Fecha" es obligatorio.',
            'id_registro_vehicular.required' => 'El campo "vehículo" es obligatorio.',
            'num_factura.required' => 'El campo "Fecha" es obligatorio.',
            'precio.required' => 'El campo "Precio" es obligatorio.',
        ]);

    
        try {

            $entradas = $request->input('entradas');

            // Si el tipo es litros, convertir a galones.
            if ($request->input('tipo') === 'litros' && $entradas !== null) {
                $entradas = $entradas * 3.785;
            }
            
            // Crear un nuevo registro de combustible.
            $registrocombustible = new RegistroCombustible();
            $registrocombustible->id_registro_vehicular = $request->input('id_registro_vehicular');
            $registrocombustible->fecha = $request->input('fecha');
            $registrocombustible->num_factura = $request->input('num_factura');
            $registrocombustible->tipo = $request->input('tipo');
            $registrocombustible->entradas = $entradas !== null ? $entradas : null;
            $registrocombustible->salidas = $request->input('salidas') ?: null;
            $registrocombustible->precio = $request->input('precio');
            $registrocombustible->observacion = $request->input('observacion');
            
            // Guardar el nuevo registro.
            $registrocombustible->save();
            // Mostrar mensaje de éxito con SweetAlert.
            Alert::success('Éxito', '¡Nuevo registro creado con éxito!');
    
            // Redirigir a la vista de la lista de registros (solo en éxito).
            return redirect()->route('registrocombustible.index');
    
        } catch (\Exception $e) {
            // Si algo falla, mostrar el error.
            Alert::error('Error', 'Hubo un problema al crear el registro. Inténtalo de nuevo.');
    
            // Volver a la vista del formulario con los errores.
            return back();  // 'back()' asegura que regrese a la misma página.
        }
    
    }
    

    public function edit($id)
    {
        // Busca el registro de combustible por su ID.
        $registro = RegistroCombustible::findOrFail($id);
        $vehiculos = RegistroVehicular::all(); // Obtiene todos los vehículos para el select
         // Si el tipo de medida es 'litros' y hay una entrada registrada, se convierte a galones (1 galón = 3.785 litros).
        if ($registro->tipo === 'litros' && $registro->entradas !== null) {
            // Se formatea la cantidad convertida a 2 decimales.
            $registro->entradas = number_format($registro->entradas / 3.785, 2, '.', '');
        }
        // Devuelve la vista de edición con los datos del registro de combustible y la lista de vehículos.
        return view('registrocombustible.RCEdit', compact('registro', 'vehiculos'));
    }
    // Función que se encarga de registrar una salida de combustible (actualizar la cantidad disponible).
    public function update(Request $request, $id) 
    {
        // Validación de los campos en Laravel
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required|exists:registro_vehiculars,id',
            'num_factura' => 'required|integer',
            'tipo' => 'required|in:galones,litros',
            'entradas' => 'nullable|numeric|min:0',
            'salidas' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'observacion' => 'nullable|string|max:60', 
        ], [
            'fecha.required' => 'El campo "Fecha" es obligatorio.',
            'id_registro_vehicular.required' => 'El campo "vehículo" es obligatorio.',
            'num_factura.required' => 'El campo "Número de factura" es obligatorio.',
            'precio.required' => 'El campo "Precio" es obligatorio.',
            'observacion.max' => 'La observación no puede tener más de 60 caracteres.',
        ]);

        // Buscar el registro en la base de datos
        $registro = RegistroCombustible::findOrFail($id);

        try {
            // Obtiene el valor de las entradas desde el formulario (puede representar litros o galones).
            $entradas = $request->input('entradas');
            // Obtiene el tipo de unidad ingresada ('litros' o 'galones')
            $tipo = $request->input('tipo');
             // Si el tipo ingresado es 'litros' y hay un valor en entradas.
            if ($tipo === 'litros' && $entradas !== null) {
                // Convierte los litros a galones (1 galón = 3.785 litros).
                $entradas = $entradas * 3.785;  
            }
        

            // Actualizar los campos
            $registro->update([
                'fecha' => $request->fecha,
                'id_registro_vehicular' => $request->id_registro_vehicular,
                'num_factura' => $request->num_factura,
                'tipo' => $request->tipo,
               'entradas'  => $entradas !== null ? floor($entradas * 1000) / 1000 : null,
                'salidas' => $request->salidas,
                'precio' => $request->precio,
                'observacion' => $request->observacion,
            ]);
            

            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Registro actualizado correctamente!');

            // Redirigir con mensaje de éxito
            return redirect()->route('registrocombustible.index');

        } catch (\Exception $e) {
            // Mostrar mensaje de error con SweetAlert si ocurre un problema
            Alert::error('Error', 'Hubo un problema al actualizar el registro.');

            // Volver a la vista del formulario con los errores
            return back();
        }
    }
     
    // Función que elimina un registro de combustible junto con su historial relacionado.
    public function destroy(string $id)
    {
        try {
            // Buscar el registro y eliminarlo
            $registro = RegistroCombustible::findOrFail($id);
            $registro->delete();

            // Respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            // Respuesta de error
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ], 500);
        }
    }



}