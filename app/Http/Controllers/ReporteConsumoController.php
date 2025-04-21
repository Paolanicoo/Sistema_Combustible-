<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;
use Illuminate\Support\Facades\DB;

class ReporteConsumoController extends Controller
{
    public function reportesConsumo(Request $request)
    {
        $tipo = $request->input('tipo', 'mes'); // Por defecto, 'mes'

        // Inicializar todas las variables como arrays vacíos
        $consumoPorMes = [];
        $consumoPorAnio = [];
        $consumoPorEquipo = [];
        $consumoPorAsignado = [];
        
        switch ($tipo) {
            case 'mes':
                $consumoPorMes = RegistroCombustible::selectRaw('MONTH(fecha) as mes, SUM(COALESCE(entradas, 0) * 3.785 + COALESCE(salidas, 0)) as total')
                    ->groupBy('mes')
                    ->orderBy('mes')
                    ->get();
                break;

            case 'anio':
                $consumoPorAnio = RegistroCombustible::selectRaw('YEAR(fecha) as anio, SUM(COALESCE(entradas, 0)* 3.785 + COALESCE(salidas, 0)) as total')
                    ->groupBy('anio')
                    ->orderBy('anio')
                    ->get();
                break;

            case 'equipo':
                $consumoPorEquipo = RegistroCombustible::join('registro_vehiculars', 'registro_combustibles.id_registro_vehicular', '=', 'registro_vehiculars.id')
                    ->selectRaw('registro_vehiculars.equipo, SUM(COALESCE(entradas, 0) * 3.785 + COALESCE(salidas, 0)) as total')
                    ->groupBy('registro_vehiculars.equipo')
                    ->orderBy('total', 'DESC')
                    ->get();
                break;

                case 'asignado':
                    // Total global de galones de todos los registros
                    $totalGalonesGlobal = RegistroCombustible::selectRaw('SUM(COALESCE(entradas, 0) * 3.785 + COALESCE(salidas, 0)) as total')
                        ->value('total');
                
                    // Consumo por asignado con porcentaje
                    $consumoPorAsignado = RegistroCombustible::join('registro_vehiculars', 'registro_combustibles.id_registro_vehicular', '=', 'registro_vehiculars.id')
                        ->selectRaw('
                            registro_vehiculars.asignado,
                            COUNT(*) as registros,
                            SUM(COALESCE(entradas, 0) * 3.785 + COALESCE(salidas, 0)) as total,
                            ROUND((SUM(COALESCE(entradas, 0) * 3.785 + COALESCE(salidas, 0)) / ?) * 100, 2) as porcentaje
                        ', [$totalGalonesGlobal])
                        ->groupBy('registro_vehiculars.asignado')
                        ->orderBy('total', 'DESC')
                        ->get();
                    break;
                
        }

        return response()->json([
            'consumoPorMes' => $consumoPorMes,
            'consumoPorAnio' => $consumoPorAnio,
            'consumoPorEquipo' => $consumoPorEquipo,
            'consumoPorAsignado' => $consumoPorAsignado,
            
        ]);
    }
}
