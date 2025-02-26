<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroCombustible;
use App\Models\RegistroVehicular;
use App\Models\ResumenImporte;
use Illuminate\Support\Facades\Auth;

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

    // Cargar solo los datos del reporte seleccionado
    switch ($tipo) {
        case 'mes':
            $consumoPorMes = ResumenImporte::selectRaw('MONTH(fecha) as mes, SUM(total) as total')
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();
            break;

        case 'anio':
            $consumoPorAnio = ResumenImporte::selectRaw('YEAR(fecha) as anio, SUM(total) as total')
                ->groupBy('anio')
                ->orderBy('anio')
                ->get();
            break;

        case 'equipo':
            $consumoPorEquipo = ResumenImporte::join('registro_vehiculars', 'resumen_importes.id_registro_vehicular', '=', 'registro_vehiculars.id')
                ->selectRaw('registro_vehiculars.equipo, SUM(resumen_importes.total) as total')
                ->groupBy('registro_vehiculars.equipo')
                ->orderBy('total', 'DESC')
                ->get();
            break;

        case 'asignado':
            $consumoPorAsignado = ResumenImporte::join('registro_vehiculars', 'resumen_importes.id_registro_vehicular', '=', 'registro_vehiculars.id')
                ->selectRaw('registro_vehiculars.asignado, SUM(resumen_importes.total) as total')
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
