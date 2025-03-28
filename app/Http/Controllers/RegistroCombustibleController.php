<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular; 
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegistroCombustibleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }
    
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


    public function getTableData(Request $request)
    {
        try {
            $query = RegistroCombustible::with('vehiculos');
            
            // Obtener total de registros sin filtrar
            $recordsTotal = $query->count();
            
            // Aplicar búsqueda global si existe
            if ($request->has('search') && !empty($request->input('search.value'))) {
                $searchValue = $request->input('search.value');
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
            
            // Obtener total de registros después del filtrado
            $recordsFiltered = $query->count();
            
            // Ordenar resultados - manejo simplificado para evitar errores
            if ($request->has('order') && $request->input('order.0.column') !== null) {
                $columnIndex = $request->input('order.0.column');
                $columnName = $request->input("columns.{$columnIndex}.data");
                $columnDirection = $request->input('order.0.dir', 'asc');
                
                // Manejar ordenamiento de columnas básicas o por defecto
                if (in_array($columnName, ['fecha', 'num_factura', 'entradas', 'salidas'])) {
                    $query->orderBy($columnName, $columnDirection);
                }
                // No intentamos ordenar por columnas relacionadas por ahora
            } else {
                // Ordenamiento por defecto si no se especifica
                $query->orderBy('fecha', 'desc');
            }
            
            // Paginación
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $combustibles = $query->skip($start)->take($length)->get();
            
            $data = $combustibles->map(function ($registro) {
                // Convertir entradas de litros a galones
                $entradasGalones = $registro->entradas * 3.785;
            
                return [
                    'id' => $registro->id,
                    'fecha' => $registro->fecha,
                    'vehiculo_equipo' => $registro->vehiculos->equipo ?? 'N/A',
                    'vehiculo_marca' => $registro->vehiculos->marca ?? 'N/A',
                    'vehiculo_placa' => $registro->vehiculos->placa ?? 'N/A',
                    'vehiculo_asignado' => $registro->vehiculos->asignado ?? 'N/A',
                    'num_factura' => $registro->num_factura,
                    // Formatear galones a 3 decimales
                    'entradas' => number_format($entradasGalones, 3, '.', ''),
                    'salidas' => number_format($registro->salidas, 3, '.', ''),
                    'observacion' => $registro->observacion,
                    'acciones' => view('RegistroCombustible.actions', compact('registro'))->render()
                ];
            });
            
            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en DataTables: ' . $e->getMessage());
            return response()->json([
                "draw" => intval($request->input('draw', 1)),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => "Error al procesar los datos: " . $e->getMessage()
            ]);
        }
    }


    public function create() 
    {
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos
        return view('RegistroCombustible.RCCreate', compact('vehiculos'));
    }

 
    public function store(Request $request) 
    {
       // Validación de los campos en Laravel
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required|exists:registro_vehiculars,id',
            'num_factura' => 'required|string|max:10',
            'entradas' => 'nullable|numeric|min:0',
            'salidas' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'observacion' => 'nullable|string|max:255',
        ], [
            'num_factura' => 'El numero de factura es requerido.',
            'entradas.numeric' => 'El campo entradas debe ser un número.',
            'salidas.numeric' => 'El campo salidas debe ser un número.',
            'precio.numeric' => 'El campo precio debe ser un número.',
        ]);

    
        try {
            // Crear un nuevo registro de combustible
            $registrocombustible = new RegistroCombustible();
            $registrocombustible->id_registro_vehicular = $request->input('id_registro_vehicular');
            $registrocombustible->fecha = $request->input('fecha');
            $registrocombustible->num_factura = $request->input('num_factura');
            $registrocombustible->entradas = $request->input('entradas') ? number_format($request->input('entradas'), 3, '.', '') : null;
            $registrocombustible->salidas = $request->input('salidas') ?: null;
            $registrocombustible->precio = $request->input('precio');
            $registrocombustible->observacion = $request->input('observacion');

            // Guardar el nuevo registro
            $registrocombustible->save();
    
            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Nuevo registro creado con éxito!');
    
            // Redirigir a la vista de la lista de registros (solo en éxito)
            return redirect()->route('registrocombustible.index');
    
        } catch (\Exception $e) {
            // Si algo falla, mostrar el error
            Alert::error('Error', 'Hubo un problema al crear el registro. Inténtalo de nuevo.');
    
            // Volver a la vista del formulario con los errores
            return back();  // 'back()' asegura que regrese a la misma página
        }
    
    }
    

    public function show(string $id) // SOLO QUE MUESTRA UN DATO INDIVIDUAL
    {
        
    }

  
    public function edit($id)
    {
        $registro = RegistroCombustible::findOrFail($id);
        $vehiculos = RegistroVehicular::all(); // Obtiene todos los vehículos para el select

        return view('registrocombustible.RCEdit', compact('registro', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required|exists:registro_vehiculars,id',
            'num_factura' => 'required|integer',
            'entradas' => 'nullable|numeric|min:0',
            'salidas' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'observacion' => 'nullable|string|max:255',
        ]);

        // Limpiar y convertir valores numéricos
        $entradas = $request->entradas ? str_replace([',', ' '], '', $request->entradas) : null;
        $salidas = $request->salidas ? str_replace([',', ' '], '', $request->salidas) : null;
        $precio = str_replace([',', ' '], '', $request->precio);

        // Buscar el registro en la base de datos
        $registro = RegistroCombustible::findOrFail($id);

        try {
            // Actualizar los campos
            $registro->update([
                'fecha' => $request->fecha,
                'id_registro_vehicular' => $request->id_registro_vehicular,
                'num_factura' => $request->num_factura,
                'entradas' => $entradas,
                'salidas' => $salidas,
                'precio' => $precio,
                'observacion' => $request->observacion,
            ]);

            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Registro actualizado correctamente!');

            // Redirigir con mensaje de éxito
            return redirect()->route('registrocombustible.index');

        } catch (\Exception $e) {
            // Registrar el error para depuración
            \Log::error('Error al actualizar registro de combustible: ' . $e->getMessage());

            // Mostrar mensaje de error con SweetAlert si ocurre un problema
            Alert::error('Error', 'Hubo un problema al actualizar el registro: ' . $e->getMessage());

            // Volver a la vista del formulario con los errores
            return back()->withInput();
        }
    }

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