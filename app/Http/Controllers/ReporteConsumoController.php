<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;
use Illuminate\Support\Facades\DB;

class ReporteConsumoController extends Controller
{
    //Muestra distintos tipos de reportes de consumo de combustible.
    public function reportesConsumo(Request $request)
    {
        $tipo = $request->input('tipo', 'mes'); // Por defecto, 'mes'

        // Inicializar todas las variables como arrays vacíos
        $consumoPorMes = [];
        $consumoPorAnio = [];
        $consumoPorEquipo = [];
        $consumoPorAsignado = [];
        // Evaluar el tipo de reporte para obtener los datos correspondientes.
        switch ($tipo) {
            // Reporte de consumo por mes
            case 'mes':
                $consumoPorMes = RegistroCombustible::selectRaw('MONTH(fecha) as mes, SUM(COALESCE(entradas, 0) + COALESCE(salidas, 0)) as total')
                    ->groupBy('mes')
                    ->orderBy('mes')
                    ->get();
                break;
            // Reporte de consumo por año.
            case 'anio':
                $consumoPorAnio = RegistroCombustible::selectRaw('YEAR(fecha) as anio, SUM(COALESCE(entradas, 0) + COALESCE(salidas, 0)) as total')
                    ->groupBy('anio')
                    ->orderBy('anio')
                    ->get();
                break;
            // Reporte de consumo por equipo.
            case 'equipo':
                $consumoPorEquipo = RegistroCombustible::join('registro_vehiculars', 'registro_combustibles.id_registro_vehicular', '=', 'registro_vehiculars.id')
                    ->selectRaw('registro_vehiculars.equipo, SUM(COALESCE(entradas, 0)  + COALESCE(salidas, 0)) as total')
                    ->groupBy('registro_vehiculars.equipo')
                    ->orderBy('total', 'DESC')
                    ->get();
                break;
                // Reporte de consumo por persona asignada.
                case 'asignado':
                    // Total global de galones de todos los registros.
                    $totalGalonesGlobal = RegistroCombustible::selectRaw('SUM(COALESCE(entradas, 0)  + COALESCE(salidas, 0)) as total')
                        ->value('total'); // Obtener un solo valor numérico.
                
                    // Consumo por asignado con porcentaje.
                    $consumoPorAsignado = RegistroCombustible::join('registro_vehiculars', 'registro_combustibles.id_registro_vehicular', '=', 'registro_vehiculars.id')
                        ->selectRaw('
                            registro_vehiculars.asignado,
                            COUNT(*) as registros,
                            SUM(COALESCE(entradas, 0)  + COALESCE(salidas, 0)) as total,
                            ROUND((SUM(COALESCE(entradas, 0)  + COALESCE(salidas, 0)) / ?) * 100, 2) as porcentaje
                        ', [$totalGalonesGlobal])
                        ->groupBy('registro_vehiculars.asignado')
                        ->orderBy('total', 'DESC')
                        ->get();
                    break;
                
        }
        // Retornar la respuesta en formato JSON con los datos según el tipo de reporte.
        return response()->json([
            'consumoPorMes' => $consumoPorMes,
            'consumoPorAnio' => $consumoPorAnio,
            'consumoPorEquipo' => $consumoPorEquipo,
            'consumoPorAsignado' => $consumoPorAsignado,
            
        ]);
    }
}
