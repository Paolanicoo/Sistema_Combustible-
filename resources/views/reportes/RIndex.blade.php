@extends('layouts.app')

@section('contenido')
<div class="container">
    <h2 class="text-center">Reportes de Consumo</h2>

    <!-- Filtro para seleccionar reporte -->
    <div class="mb-4">
        <label for="tipoReporte">Seleccionar Reporte:</label>
        <select id="tipoReporte" class="form-control">
            <option value="">-- Selecciona --</option>
            <option value="mes">Consumo por Mes</option>
            <option value="anio">Consumo por Año</option>
            <option value="equipo">Consumo por Equipo</option>
            <option value="asignado">Consumo por Asignado</option>
        </select>
    </div>

    <!-- Contenedores para los gráficos -->
    <canvas id="graficaConsumoMes" class="d-none"></canvas>
    <canvas id="graficaConsumoAnio" class="d-none"></canvas>
    <canvas id="graficaConsumoEquipo" class="d-none"></canvas>
    <canvas id="graficaConsumoAsignado" class="d-none"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let chart = null; // Variable para guardar el gráfico actual
        
        function crearGrafico(id, tipo, etiquetas, datos, titulo) {
            var ctx = document.getElementById(id).getContext('2d');

            if (chart) {
                chart.destroy(); // Eliminar gráfico anterior
            }

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

        document.getElementById('tipoReporte').addEventListener('change', function () {
            const tipo = this.value;

            // Ocultar todos los gráficos
            document.querySelectorAll('canvas').forEach(canvas => {
                canvas.classList.add('d-none');
            });

            if (tipo === '') return;

            // Realizar la petición AJAX
            fetch(`/reportes/consumo?tipo=${tipo}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Verifica los datos en la consola

                    let etiquetas = [];
                    let valores = [];

                    if (tipo === 'mes' && data.consumoPorMes.length > 0) {
                        etiquetas = data.consumoPorMes.map(m => `Mes ${m.mes}`);
                        valores = data.consumoPorMes.map(m => m.total);
                        document.getElementById('graficaConsumoMes').classList.remove('d-none');
                        crearGrafico('graficaConsumoMes', 'bar', etiquetas, valores, 'Consumo por Mes');
                    }

                    if (tipo === 'anio' && data.consumoPorAnio.length > 0) {
                        etiquetas = data.consumoPorAnio.map(a => a.anio);
                        valores = data.consumoPorAnio.map(a => a.total);
                        document.getElementById('graficaConsumoAnio').classList.remove('d-none');
                        crearGrafico('graficaConsumoAnio', 'line', etiquetas, valores, 'Consumo por Año');
                    }

                    if (tipo === 'equipo' && data.consumoPorEquipo.length > 0) {
                        etiquetas = data.consumoPorEquipo.map(e => e.equipo);
                        valores = data.consumoPorEquipo.map(e => e.total);
                        document.getElementById('graficaConsumoEquipo').classList.remove('d-none');
                        crearGrafico('graficaConsumoEquipo', 'doughnut', etiquetas, valores, 'Consumo por Equipo');
                    }

                    if (tipo === 'asignado' && data.consumoPorAsignado.length > 0) {
                        etiquetas = data.consumoPorAsignado.map(a => a.asignado);
                        valores = data.consumoPorAsignado.map(a => a.total);
                        document.getElementById('graficaConsumoAsignado').classList.remove('d-none');
                        crearGrafico('graficaConsumoAsignado', 'pie', etiquetas, valores, 'Consumo por Asignado');
                    }
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        });
    });
</script>

@endsection
