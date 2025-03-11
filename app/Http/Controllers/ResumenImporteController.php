<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResumenImporte;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class ResumenImporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }
    
    public function index(Request $request)
    {
        
        $registroimporte = ResumenImporte::paginate(10);
        $vehiculos = RegistroVehicular::all();
        $combustibles = RegistroCombustible::all();

        $query = ResumenImporte::query();

        // Obtener los filtros de búsqueda
        $equipo = $request->input('equipo');
        $asignado = $request->input('asignado');
        $mes = $request->input('mes');

        
        $query = ResumenImporte::with(['vehiculo', 'combustible']);

        // Aplicar filtros si existen
        if ($equipo) {
            $query->whereHas('vehiculo', function ($q) use ($equipo) {
                $q->where('equipo', 'LIKE', "%$equipo%");
            });
        }

        if ($asignado) {
            $query->whereHas('vehiculo', function ($q) use ($asignado) {
                $q->where('asignado', 'LIKE', "%$asignado%");
            });
        }

        if ($mes) {
            $query->whereMonth('fecha', $mes);
        }
        // Obtener resultados paginados
        $registroimporte = $query->paginate(10);



        // Agregar los datos del vehículo a cada registro de combustible
        $registroimporte->transform(function ($registro) use ($vehiculos, $combustibles) {
            $vehiculo = $vehiculos->firstWhere('id', $registro->id_registro_vehicular);
            $combustible = $combustibles->firstWhere('id', $registro->id_registro_combustible);

            // Agregar datos relacionados
            $registro->vehiculo = $vehiculo;
            $registro->combustible = $combustible;

            // Calcular el total
            if ($combustible) {
                $registro->total = $combustible->salidas * $combustible->precio;
            } else {
                $registro->total = 0;
            }

            return $registro;
        });

        return view('RegistroImporte.RIIndex', compact('registroimporte', 'combustibles', 'vehiculos'));
    }

    public function getTableData(Request $request)
    {
        $importes = ResumenImporte::with('vehiculo', 'combustible')->paginate(10); // Cargar relaciones

        return response()->json([
            "draw" => $request->input('draw'),
            "recordsTotal" => $importes->total(),
            "recordsFiltered" => $importes->total(),
            "data" => $importes->map(function ($registro) {
                return [
                    'mes' => \Carbon\Carbon::parse($registro->fecha)->locale('es')->translatedFormat('F'),
                    'fecha' => $registro->combustible->fecha ?? 'N/A',
                    'equipo' => $registro->vehiculo->equipo ?? 'N/A',
                    'marca' => $registro->vehiculo->marca ?? 'N/A',
                    'placa' => $registro->vehiculo->placa ?? 'N/A',
                    'asignado' => $registro->vehiculo->asignado ?? 'N/A',
                    'num_factura' => $registro->combustible->num_factura ?? 'N/A',
                    'consumo' => optional($registro->combustible)->entradas > 0 
                        ? optional($registro->combustible)->entradas 
                        : optional($registro->combustible)->salidas ?? 'N/A',
                    'precio' => $registro->combustible->precio ?? 'N/A',
                    'total' => (optional($registro->combustible)->entradas > 0 
                        ? optional($registro->combustible)->entradas 
                        : optional($registro->combustible)->salidas) * optional($registro->combustible)->precio ?? 'N/A',
                    'empresa' => $registro->empresa,
                    'tipo' => $registro->cog,
                    'acciones' => view('RegistroImporte.actions', compact('registro'))->render()
                ];
            })
        ]);
    }

 

    public function create()
    {
        $vehiculos = RegistroVehicular::all(); // Obtener todos los vehículos
    $combustibles = RegistroCombustible::all(); // Obtener todos los registros de combustible
    
    return view('RegistroImporte.RICreate', compact('vehiculos', 'combustibles'));
    
    }

    public function store(Request $request)
    {
        // Validación de los campos requeridos
        $request->validate([
            'fecha' => 'required',
            'precio' => 'required',
            'total' => 'required',
            'empresa' => 'required',
            'cog' => 'required'
        ], [
            'empresa.required' => 'El campo Empresa es obligatorio.',
            'cog.required' => 'El campo Tipo es obligatorio.',
        ]);

        try {
            // Calcular el consumo y el total
            $consumo = $request->input('entradas') > 0 ? $request->input('entradas') : $request->input('salidas');
            $precio = $request->input('precio');
            $total = $consumo * $precio; // Calcular el total correctamente

            // Crear el nuevo registro
            $registroimporte = new ResumenImporte();
            $registroimporte->fecha = $request->input('fecha');
            $registroimporte->id_registro_vehicular = $request->input('id_registro_vehicular');
            $registroimporte->id_registro_combustible = $request->input('id_registro_combustible');
            $registroimporte->total = $total; // Guardar el total correctamente
            $registroimporte->empresa = $request->input('empresa');
            $registroimporte->cog = $request->input('cog');
            $registroimporte->save();

            // Mostrar mensaje de éxito con SweetAlert
            Alert::success('Éxito', '¡Nuevo registro creado con éxito!');

            // Redirigir a la vista de lista de registros (si todo fue bien)
            return redirect()->route('registroimporte.index');

        } catch (\Exception $e) {
            // Si ocurre un error durante la creación del registro
            Alert::error('Error', 'Hubo un problema al crear el registro. Inténtalo de nuevo.');

            // Volver a la vista del formulario con los errores
            return back()->withInput(); // 'back()' mantiene al usuario en la misma vista
        }
    }

    public function show(string $id)
    {
        //
    }
    
    public function edit($id)
    {
        $registro = ResumenImporte::findOrFail($id);
        $vehiculos = RegistroVehicular::all();
        $combustibles = RegistroCombustible::all();

        return view('registroimporte.RIEdit', compact('registro', 'vehiculos', 'combustibles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_registro_vehicular' => 'required',
            'id_registro_combustible' => 'required',
            'precio' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'empresa' => 'required|string',
            'cog' => 'required|in:Gasto,Costo',

        ], [
            'empresa.required' => 'El campo Empresa es obligatorio.',
            'cog.required' => 'El campo Tipo es obligatorio.',
        ]);

        // Obtener el registro de combustible asociado
        $combustible = RegistroCombustible::findOrFail($request->id_registro_combustible);

        // Determinar el consumo (salidas o entradas)
        $consumo = $combustible->salidas > 0 ? $combustible->salidas : $combustible->entradas;

        // Calcular el total de la compra
        $total = $consumo * ($request->precio ?? $combustible->precio);

        // Actualizar el registro
        $registro = ResumenImporte::findOrFail($id);
        $registro->update([
            'fecha' => $request->fecha,
            'id_registro_vehicular' => $request->id_registro_vehicular,
            'id_registro_combustible' => $request->id_registro_combustible,
            'precio' => $request->precio ?? $combustible->precio,
            'total' => $total,
            'empresa' => $request->empresa,
            'cog' => $request->cog,
            
        ]);
        Alert::success('Éxito', '¡Registro actualizado correctamente!');
        return redirect()->route('registroimporte.index', $id);
    }

    public function destroy(string $id)
    {
        try {
            // Buscar el registro por ID
            $registro = ResumenImporte::findOrFail($id);
            
            // Eliminar el registro
            $registro->delete();

            // Retornar una respuesta JSON
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error, retornar un mensaje de error
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro'
            ], 500);
        }
    }
}
