@extends('layouts.app')

@section('contenido')
<div class="container">
    <h2 class="text-center">Reportes de Consumo</h2>

    <!-- Filtro para seleccionar reporte -->
    <div class="mb-4">
        <label for="tipoReporte">Seleccionar Reporte:</label>
        <select id="tipoReporte" class="form-control">
            <option value="">-- Selecciona --</option>
            <option value="anio">Comparativo Anual</option>
            <option value="mes">Consumo por Mes</option>
            <option value="equipo">Consumo por Equipo</option>
            <option value="asignado">Consumo por Asignado</option>
        </select>
    </div>

    <!-- Contenedor para la gráfica comparativa anual -->
    <canvas id="graficaConsumoAnio" class="d-none"></canvas>

    <!-- Contenedores para las tablas -->
    <div id="tablaConsumoMes" class="d-none"></div>
    <div id="tablaConsumoEquipo" class="d-none"></div>
    <div id="tablaConsumoAsignado" class="d-none"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let urlReporte = "{{ route('reportes.consumo') }}";
        let chart = null;

        function crearGrafico(id, tipo, etiquetas, datos, titulo) {
            var ctx = document.getElementById(id).getContext('2d');
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: tipo,
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: titulo,
                        data: datos,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                    
                }
            });
        }

            function crearTabla(id, data, columnas) {
                let tabla = `<table class='table table-bordered'><thead><tr>`;
                columnas.forEach(col => {
                    let titulo = col.charAt(0).toUpperCase() + col.slice(1); // Convertir primera letra a mayúscula
                    tabla += `<th>${titulo}</th>`;
                });
                tabla += `</tr></thead><tbody>`;
                data.forEach(row => {
                    tabla += `<tr>`;
                    columnas.forEach(col => tabla += `<td>${row[col]}</td>`);
                    tabla += `</tr>`;
                });
                tabla += `</tbody></table>`;
                document.getElementById(id).innerHTML = tabla;
            }

        document.getElementById('tipoReporte').addEventListener('change', function () {
            const tipo = this.value;

            document.querySelectorAll('canvas, div[id^=tabla]').forEach(el => el.classList.add('d-none'));

            if (!tipo) return;

            fetch(`${urlReporte}?tipo=${tipo}`)
                .then(response => response.json())
                .then(data => {
                    if (tipo === 'anio' && data.consumoPorAnio.length > 0) {
                        const etiquetas = data.consumoPorAnio.map(a => a.anio);
                        const valores = data.consumoPorAnio.map(a => a.total);
                        document.getElementById('graficaConsumoAnio').classList.remove('d-none');
                        crearGrafico('graficaConsumoAnio', 'line', etiquetas, valores, 'Comparativo Anual');

                    } else if (tipo === 'mes' && data.consumoPorMes.length > 0) {
                const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                
                // Convertimos el número del mes a nombre antes de crear la tabla
                let consumoMes = data.consumoPorMes.map(item => ({
                    mes: meses[item.mes - 1], // Restamos 1 porque los arrays en JS comienzan desde 0
                    total: item.total
                }));

                document.getElementById('tablaConsumoMes').classList.remove('d-none');
                crearTabla('tablaConsumoMes', consumoMes, ['mes', 'total']);
            
                    } else if (tipo === 'equipo' && data.consumoPorEquipo.length > 0) {
                        document.getElementById('tablaConsumoEquipo').classList.remove('d-none');
                        crearTabla('tablaConsumoEquipo', data.consumoPorEquipo, ['equipo', 'total']);

                    } else if (tipo === 'asignado' && data.consumoPorAsignado.length > 0) {
                        document.getElementById('tablaConsumoAsignado').classList.remove('d-none');
                        crearTabla('tablaConsumoAsignado', data.consumoPorAsignado, ['asignado', 'total']);
                    }
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        });
    });
</script>
@endsection
