@extends('layouts.app')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header text-center">
            <h2 class="mb-0" style="color: black;">Reportes de consumo de combustible</h2>
        </div>
        <div class="card-body">
            <!-- Filtro para seleccionar reporte -->
            <div class="mb-4">
                <label for="tipoReporte" class="form-label fw-bold" style="color:rgb(8, 8, 8);">Seleccionar Reporte:</label>
                <select id="tipoReporte" class="form-select" style="width: 250px; margin-left: 0;">
                    <option value="">-- Selecciona --</option>
                    <option value="anio">📅 Comparativo anual</option>
                    <option value="mes">📆 Consumo por mes</option>
                    <option value="equipo">🚌 Consumo por equipo</option>
                    <option value="asignado">👤 Consumo por asignado</option>
                </select>
            </div>

            <!-- Botones de exportación -->
            <div class="mb-4 text-end">
                <button id="btnExportarPDF" class="btn btn-danger btn-sm d-none">
                    <i class="fas fa-file-pdf"></i> Exportar a PDF
                </button>
                <button id="btnExportarExcel" class="btn btn-success btn-sm d-none">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </button>
            </div>

            <!-- Contenedor de gráfica y tabla -->
            <div class="row">
                <!-- Gráfica -->
                <div class="col-md-6 d-flex justify-content-center">
                    <canvas id="graficaConsumoAnio" style="max-width: 100%; max-height: 300px;"></canvas>
                </div>

                <!-- Tabla -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div id="tablaConsumoAnio" class="d-none" style="width: 80%;"></div>
                </div>
            </div>
            
            <!-- Contenedor dedicado para tablas de mes, equipo y asignado -->
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-center">
                    <div id="tablaConsumoMes" class="d-none" style="width: 90%; max-width: 600px;"></div>
                    <div id="tablaConsumoEquipo" class="d-none" style="width: 90%; max-width: 600px;"></div>
                    <div id="tablaConsumoAsignado" class="d-none" style="width: 90%; max-width: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo para centrar el contenido de las celdas */
    .table td, .table th {
        text-align: center;
        vertical-align: middle;
    }
    
    /* Estilo para filas alternas */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
        let tabla = `<table class='table table-bordered table-striped'><thead class="bg-light"><tr>`;
        columnas.forEach(col => {
            let titulo = col === 'anio' ? 'Año' : (col === 'total' ? 'Total galones' : col.charAt(0).toUpperCase() + col.slice(1));
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
                let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`; 
                let tablaContainer = document.getElementById(tablaId);

                if (tipo === 'anio' && data.consumoPorAnio.length > 0) {
                    const etiquetas = data.consumoPorAnio.map(a => a.anio);
                    const valores = data.consumoPorAnio.map(a => a.total);

                    document.getElementById('graficaConsumoAnio').classList.remove('d-none');
                    crearGrafico('graficaConsumoAnio', 'bar', etiquetas, valores, 'Comparativo Anual');

                    crearTabla(tablaId, data.consumoPorAnio, ['anio', 'total']);
                } else if (tipo === 'mes' && data.consumoPorMes.length > 0) {
                    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    let consumoMes = data.consumoPorMes.map(item => ({ mes: meses[item.mes - 1], total: item.total }));

                    crearTabla(tablaId, consumoMes, ['mes', 'total']);
                } else if (tipo === 'equipo' && data.consumoPorEquipo.length > 0) {
                    crearTabla(tablaId, data.consumoPorEquipo, ['equipo', 'total']);
                } else if (tipo === 'asignado' && data.consumoPorAsignado.length > 0) {
                    crearTabla(tablaId, data.consumoPorAsignado, ['asignado', 'total']);
                }

                tablaContainer.classList.remove('d-none');
                document.querySelectorAll('#btnExportarPDF, #btnExportarExcel').forEach(btn => btn.classList.remove('d-none'));
            })
            .catch(error => console.error('Error al cargar los datos:', error));
    });

    document.getElementById('btnExportarPDF').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF();

        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let tabla = document.getElementById(tablaId).querySelector("table");

        let titulo = "Reporte de Consumo de Combustible";
        switch (tipo) {
            case "anio":
                titulo += " - Anual";
                break;
            case "mes":
                titulo += " - Mensual";
                break;
            case "asignado":
                titulo += " - Por Asignado";
                break;
            case "equipo":
                titulo += " - Por Equipo";
                break;
            default:
                titulo += " - General";
                break;
        }

        doc.text(titulo, 20, 10);
        doc.autoTable({ html: tabla });
        doc.save("reporte_consumo.pdf");
    });

    document.getElementById('btnExportarExcel').addEventListener('click', function () {
        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let tabla = document.getElementById(tablaId).querySelector("table");
        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.table_to_sheet(tabla);
        XLSX.utils.book_append_sheet(wb, ws, "Reporte");
        XLSX.writeFile(wb, "reporte_consumo.xlsx");
    });
});
</script>
@endsection
