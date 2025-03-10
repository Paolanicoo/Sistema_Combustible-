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

    <!-- Botones de exportación -->
    <div class="mb-3">
        <button id="btnImprimir" class="btn btn-primary d-none">Imprimir</button>
        <button id="btnExportarPDF" class="btn btn-danger d-none">Exportar a PDF</button>
        <button id="btnExportarExcel" class="btn btn-success d-none">Exportar a Excel</button>
    </div>

    <!-- Contenedor para la gráfica comparativa anual -->
    <canvas id="graficaConsumoAnio" class="d-none"></canvas>

    <!-- Contenedores para las tablas -->
    <div id="tablaConsumoAnio" class="d-none"></div>
    <div id="tablaConsumoMes" class="d-none"></div>
    <div id="tablaConsumoEquipo" class="d-none"></div>
    <div id="tablaConsumoAsignado" class="d-none"></div>
</div>

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
        let tabla = `<table class='table table-bordered'><thead><tr>`;
        columnas.forEach(col => {
            let titulo = col === 'anio' ? 'Año' : (col === 'total' ? 'Total Galones' : col.charAt(0).toUpperCase() + col.slice(1));
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
                document.querySelectorAll('#btnImprimir, #btnExportarPDF, #btnExportarExcel').forEach(btn => btn.classList.remove('d-none'));
            })
            .catch(error => console.error('Error al cargar los datos:', error));
    });

    document.getElementById('btnImprimir').addEventListener('click', function () {
        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let contenido = document.getElementById(tablaId).innerHTML;
        let ventana = window.open('', '', 'width=800,height=600');
        ventana.document.write(`<html><head><title>Reporte</title></head><body>${contenido}</body></html>`);
        ventana.document.close();
        ventana.print();
    });

    document.getElementById('btnExportarPDF').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF();
        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let tabla = document.getElementById(tablaId).querySelector("table");
        doc.text("Reporte de Consumo", 20, 10);
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
