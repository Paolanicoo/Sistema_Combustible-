@extends('layouts.app')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header" style="background-color: #e8f4fd; color: #333;">
            <h2 class="mb-0 text-center"><i class="fas fa-gas-pump me-2"></i>Reportes de consumo de combustible</h2>
        </div>
        <div class="card-body bg-light">
            <!-- Filtro para seleccionar reporte -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="tipoReporte" class="form-label fw-bold" style="color: #333;">Seleccionar Reporte:</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #e8f4fd;"><i class="fas fa-filter"></i></span>
                        <select id="tipoReporte" class="form-select" style="border-color: #e8f4fd;">
                            <option value="">-- Selecciona un tipo de reporte --</option>
                            <option value="anio">📅 Comparativo anual</option>
                            <option value="mes">📆 Consumo por mes</option>
                            <option value="equipo">🚌 Consumo por equipo</option>
                            <option value="asignado">👤 Consumo por asignado</option>
                        </select>
                    </div>
                </div>
                
                <!-- Botones de exportación -->
                <div class="col-md-6 d-flex justify-content-end align-items-end">
                    <div class="btn-group">
                        <button id="btnExportarPDF" class="btn btn-outline-danger d-none me-2">
                            <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                        </button>
                        <button id="btnExportarExcel" class="btn btn-outline-success d-none">
                            <i class="fas fa-file-excel me-1"></i> Exportar Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Divisor decorativo -->
            <div class="text-center mb-4">
                <hr class="divider" style="width: 80%; margin: 0 auto; border-top: 1px solid #ddd;">
            </div>

            <!-- Contenedor de gráfica y tabla para reporte anual -->
            <div class="card shadow-sm mb-4" id="seccionReporteAnual" style="display: none;">
                <div class="card-header py-3" style="background-color: #e8f4fd; color: #333;">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Comparativo Anual</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Gráfica -->
                        <div class="col-md-6 mb-3">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="graficaConsumoAnio"></canvas>
                            </div>
                        </div>

                        <!-- Tabla -->
                        <div class="col-md-6">
                            <div id="tablaConsumoAnio" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenedor para reportes de mes, equipo y asignado -->
            <div class="card shadow-sm" id="seccionOtrosReportes" style="display: none;">
                <div class="card-header py-3" id="otrosReportesTitulo" style="background-color: #e8f4fd; color: #333;">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i><span id="tituloReporte">Detalle de Consumo</span></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <div id="tablaConsumoMes"></div>
                                <div id="tablaConsumoEquipo"></div>
                                <div id="tablaConsumoAsignado"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mensaje cuando no hay datos -->
            <div id="sinDatos" class="alert alert-info text-center d-none" style="background-color: #e8f4fd; color: #333; border-color: #c6e2f7;">
                <i class="fas fa-info-circle me-2"></i> No hay datos disponibles para el reporte seleccionado.
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo para las tablas */
    .table {
        width: 100%;
        margin-bottom: 0;
        color: #333;
        border-collapse: collapse;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table td, .table th {
        text-align: center;
        vertical-align: middle;
        padding: 0.75rem;
        border: 1px solid #e9ecef;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    /* Animaciones para la carga de secciones */
    .fade-in {
        animation: fadeIn 0.5s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Mejoras en los botones */
    .btn-outline-danger:hover, .btn-outline-success:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Sombras y bordes */
    .card {
        border-radius: 0.5rem;
        border: none;
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        border-bottom: none;
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
    const seccionReporteAnual = document.getElementById('seccionReporteAnual');
    const seccionOtrosReportes = document.getElementById('seccionOtrosReportes');
    const sinDatos = document.getElementById('sinDatos');
    const tituloReporte = document.getElementById('tituloReporte');

    function crearGrafico(id, tipo, etiquetas, datos, titulo) {
        var ctx = document.getElementById(id).getContext('2d');
        if (chart) chart.destroy();
        
        // Generar colores aleatorios para las barras
        const colores = etiquetas.map(() => {
            const r = Math.floor(Math.random() * 100) + 100;
            const g = Math.floor(Math.random() * 100) + 100;
            const b = Math.floor(Math.random() * 100) + 100;
            return `rgba(${r}, ${g}, ${b}, 0.7)`;
        });
        
        chart = new Chart(ctx, {
            type: tipo,
            data: {
                labels: etiquetas,
                datasets: [{
                    label: titulo,
                    data: datos,
                    backgroundColor: colores,
                    borderColor: colores.map(c => c.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Galones'
                        }
                    }
                }
            }
        });
    }

    function crearTabla(id, data, columnas) {
        let contenedor = document.getElementById(id);
        
        if (data.length === 0) {
            contenedor.innerHTML = '<div class="alert alert-info">No hay datos disponibles</div>';
            return;
        }
        
        let tabla = `<table class='table table-striped table-hover'><thead><tr>`;
        columnas.forEach(col => {
            let titulo = col === 'anio' ? 'Año' : (col === 'total' ? 'Total galones' : col.charAt(0).toUpperCase() + col.slice(1));
            tabla += `<th>${titulo}</th>`;
        });
        tabla += `</tr></thead><tbody>`;
        
        data.forEach(row => {
            tabla += `<tr>`;
            columnas.forEach(col => {
                // Formatear el valor si es numérico
                let valor = row[col];
                if (col === 'total' && !isNaN(valor)) {
                    valor = Number(valor).toLocaleString('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
                tabla += `<td>${valor}</td>`;
            });
            tabla += `</tr>`;
        });
        
        tabla += `</tbody></table>`;
        contenedor.innerHTML = tabla;
    }

    document.getElementById('tipoReporte').addEventListener('change', function () {
        const tipo = this.value;
        
        // Ocultar todas las secciones
        seccionReporteAnual.style.display = 'none';
        seccionOtrosReportes.style.display = 'none';
        sinDatos.classList.add('d-none');
        
        // Ocultar botones de exportación
        document.querySelectorAll('#btnExportarPDF, #btnExportarExcel').forEach(btn => btn.classList.add('d-none'));
        
        if (!tipo) return;
        
        // Mostrar indicador de carga
        const cargando = document.createElement('div');
        cargando.className = 'text-center my-4';
        cargando.innerHTML = '<i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Cargando datos...</p>';
        document.querySelector('.card-body').appendChild(cargando);

        fetch(`${urlReporte}?tipo=${tipo}`)
            .then(response => response.json())
            .then(data => {
                // Eliminar indicador de carga
                cargando.remove();
                
                let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`; 
                let tablaContainer = document.getElementById(tablaId);
                
                // Limpiar contenedores
                document.querySelectorAll('div[id^=tablaConsumo]').forEach(el => el.innerHTML = '');
                
                if (tipo === 'anio' && data.consumoPorAnio.length > 0) {
                    const etiquetas = data.consumoPorAnio.map(a => a.anio);
                    const valores = data.consumoPorAnio.map(a => a.total);
                    
                    seccionReporteAnual.style.display = 'block';
                    seccionReporteAnual.classList.add('fade-in');
                    
                    crearGrafico('graficaConsumoAnio', 'bar', etiquetas, valores, 'Consumo de Combustible por Año');
                    crearTabla(tablaId, data.consumoPorAnio, ['anio', 'total']);
                } else if (tipo === 'mes' && data.consumoPorMes.length > 0) {
                    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    let consumoMes = data.consumoPorMes.map(item => ({ mes: meses[item.mes - 1], total: item.total }));
                    
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Mes';
                    
                    crearTabla(tablaId, consumoMes, ['mes', 'total']);
                } else if (tipo === 'equipo' && data.consumoPorEquipo.length > 0) {
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Equipo';
                    
                    crearTabla(tablaId, data.consumoPorEquipo, ['equipo', 'total']);
                } else if (tipo === 'asignado' && data.consumoPorAsignado.length > 0) {
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Asignado';
                    
                    crearTabla(tablaId, data.consumoPorAsignado, ['asignado', 'total']);
                } else {
                    // Mostrar mensaje si no hay datos
                    sinDatos.classList.remove('d-none');
                    return;
                }
                
                // Mostrar botones de exportación
                document.querySelectorAll('#btnExportarPDF, #btnExportarExcel').forEach(btn => btn.classList.remove('d-none'));
            })
            .catch(error => {
                console.error('Error al cargar los datos:', error);
                cargando.remove();
                sinDatos.classList.remove('d-none');
            });
    });

    document.getElementById('btnExportarPDF').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF();

        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let tabla = document.getElementById(tablaId).querySelector("table");

        let titulo = "Reporte de Consumo de Combustible";
        let subtitulo = "";
        
        switch (tipo) {
            case "anio":
                subtitulo = "Comparativo Anual";
                break;
            case "mes":
                subtitulo = "Consumo por Mes";
                break;
            case "asignado":
                subtitulo = "Consumo por Asignado";
                break;
            case "equipo":
                subtitulo = "Consumo por Equipo";
                break;
        }

        // Añadir encabezado
        doc.setFontSize(16);
        doc.text(titulo, 105, 15, { align: 'center' });
        doc.setFontSize(12);
        doc.text(subtitulo, 105, 22, { align: 'center' });
        
        // Añadir fecha
        const hoy = new Date().toLocaleDateString('es-MX');
        doc.setFontSize(10);
        doc.text(`Fecha de generación: ${hoy}`, 105, 30, { align: 'center' });
        
        // Agregar tabla
        doc.autoTable({ 
            html: tabla,
            startY: 35,
            styles: { 
                halign: 'center',
                fontSize: 10
            },
            headStyles: { 
                fillColor: [240, 246, 255],
                textColor: [51, 51, 51],
                fontStyle: 'bold'
            }
        });
        
        doc.save("reporte_consumo_combustible.pdf");
    });

    document.getElementById('btnExportarExcel').addEventListener('click', function () {
        let tipo = document.getElementById('tipoReporte').value;
        let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
        let tabla = document.getElementById(tablaId).querySelector("table");
        
        let nombreArchivo = "reporte_consumo_combustible";
        let nombreHoja = "Reporte";
        
        switch (tipo) {
            case "anio":
                nombreArchivo += "_anual";
                nombreHoja = "Comparativo Anual";
                break;
            case "mes":
                nombreArchivo += "_mensual";
                nombreHoja = "Consumo por Mes";
                break;
            case "asignado":
                nombreArchivo += "_asignado";
                nombreHoja = "Consumo por Asignado";
                break;
            case "equipo":
                nombreArchivo += "_equipo";
                nombreHoja = "Consumo por Equipo";
                break;
        }
        
        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.table_to_sheet(tabla);
        XLSX.utils.book_append_sheet(wb, ws, nombreHoja);
        XLSX.writeFile(wb, `${nombreArchivo}.xlsx`);
    });
});
</script>
@endsection