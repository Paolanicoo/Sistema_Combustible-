@extends('layouts.app')

@section('contenido')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b><i class="fas fa-gas-pump me-2"></i>Reportes de consumo de combustible</b>
            </h2>
        </div>
        <div class="card-body p-4">
            <!-- Filtro para seleccionar reporte -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="tipoReporte" class="form-label fw-bold" style="color: #344767;">Seleccionar reporte:</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #f8fafc;"><i class="fas fa-filter"></i></span>
                        <select id="tipoReporte" class="form-select" style="border-color: #e2e8f0;">
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
                <hr class="divider" style="width: 80%; margin: 0 auto; border-top: 1px solid #f1f5f9;">
            </div>

            <!-- Contenedor de gráfica y tabla para reporte anual -->
            <div class="card shadow-sm mb-4" id="seccionReporteAnual" style="display: none; border-radius: 12px; border: none; box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);">
                <div class="card-header py-3" style="background-color: #f8fafc; border-radius: 12px 12px 0 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                    <h5 class="mb-0" style="color: #344767; font-weight: 600;"><i class="fas fa-chart-bar me-2"></i>Comparativo anual</h5>
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
            <div class="card shadow-sm" id="seccionOtrosReportes" style="display: none; border-radius: 12px; border: none; box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);">
                <div class="card-header py-3" id="otrosReportesTitulo" style="background-color: #f8fafc; border-radius: 12px 12px 0 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                    <h5 class="mb-0" style="color: #344767; font-weight: 600;"><i class="fas fa-table me-2"></i><span id="tituloReporte">Detalle de consumo</span></h5>
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
            <div id="sinDatos" class="alert alert-info text-center d-none" style="background-color: #f1f5f9; color: #334155; border-color: #e2e8f0; border-radius: 8px;">
                <i class="fas fa-info-circle me-2"></i> No hay datos disponibles para el reporte seleccionado.
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    
    .container {
        max-width: 1240px;
    }
    
    /* Estilos para la tarjeta principal */
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-title {
        color: #344767;
        font-weight: 600;
    }

    .card-header {
        background-color: rgb(226, 228, 230); /* Color gris claro */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
        color: #334155;
    }
    
    .table thead th {
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #f8fafc;
        text-align: center;
    }
    
    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        color: #334155;
        text-align: center;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .table tbody tr:hover {
        background-color: #f1f5f9;
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
    .btn-outline-danger, .btn-outline-success {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-outline-danger:hover, .btn-outline-success:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    /* Mejoras para select */
    .form-select:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px !important;
    }
    
    .dataTables_paginate .paginate_button.current {
        background: #0ea5e9 !important;
        border-color: #0ea5e9 !important;
        color: white !important;
    }
    
    .dataTables_paginate .paginate_button:hover {
        background: #e2e8f0 !important;
        border-color: #e2e8f0 !important;
        color: #334155 !important;
    }
    
    .dataTables_info {
        color: #64748b;
        padding-top: 1rem;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let urlReporte = "{{ route('reportes.consumo') }}";
    let chart = null;
    const seccionReporteAnual = document.getElementById('seccionReporteAnual');
    const seccionOtrosReportes = document.getElementById('seccionOtrosReportes');
    const sinDatos = document.getElementById('sinDatos');
    const tituloReporte = document.getElementById('tituloReporte');

    // Cargar las bibliotecas necesarias para exportación
    loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js');
    loadScript('https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js');

    // Función para cargar scripts externos
    function loadScript(url) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = url;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

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
        
        // Verifica si Chart está definido
        if (typeof Chart === 'undefined') {
            console.error('La biblioteca Chart.js no está cargada correctamente');
            return;
        }
        
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
        
        if (!data || data.length === 0) {
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
        cargando.id = 'indicadorCarga';
        cargando.className = 'text-center my-4';
        cargando.innerHTML = '<i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Cargando datos...</p>';
        document.querySelector('.card-body').appendChild(cargando);

        // Agregar un timestamp para evitar caché
        const timestamp = new Date().getTime();
        const url = `${urlReporte}?tipo=${tipo}&_=${timestamp}`;
        console.log("Solicitando datos a:", url);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Depuración - verificar los datos recibidos
                console.log("Datos recibidos:", data);
                
                // Eliminar indicador de carga
                const indicadorCarga = document.getElementById('indicadorCarga');
                if (indicadorCarga) indicadorCarga.remove();
                
                let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`; 
                let tablaContainer = document.getElementById(tablaId);
                
                // Limpiar contenedores
                document.querySelectorAll('div[id^=tablaConsumo]').forEach(el => el.innerHTML = '');

                // Verificar si hay datos para mostrar
                let hayDatos = false;
                let datosParaMostrar = [];
                let columnas = [];

                if (tipo === 'anio' && data.consumoPorAnio && data.consumoPorAnio.length > 0) {
                    hayDatos = true;
                    datosParaMostrar = data.consumoPorAnio;
                    columnas = ['anio', 'total'];
                    
                    const etiquetas = datosParaMostrar.map(a => a.anio);
                    const valores = datosParaMostrar.map(a => a.total);
                    
                    seccionReporteAnual.style.display = 'block';
                    seccionReporteAnual.classList.add('fade-in');
                    
                    crearGrafico('graficaConsumoAnio', 'bar', etiquetas, valores, 'Consumo de Combustible por Año');
                } else if (tipo === 'mes' && data.consumoPorMes && data.consumoPorMes.length > 0) {
                    hayDatos = true;
                    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    datosParaMostrar = data.consumoPorMes.map(item => ({ 
                        mes: meses[item.mes - 1], 
                        total: item.total 
                    }));
                    columnas = ['mes', 'total'];
                    
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Mes';
                } else if (tipo === 'equipo' && data.consumoPorEquipo && data.consumoPorEquipo.length > 0) {
                    hayDatos = true;
                    datosParaMostrar = data.consumoPorEquipo;
                    columnas = ['equipo', 'total'];
                    
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Equipo';
                } else if (tipo === 'asignado' && data.consumoPorAsignado && data.consumoPorAsignado.length > 0) {
                    hayDatos = true;
                    datosParaMostrar = data.consumoPorAsignado;
                    columnas = ['asignado', 'total'];
                    
                    seccionOtrosReportes.style.display = 'block';
                    seccionOtrosReportes.classList.add('fade-in');
                    tituloReporte.textContent = 'Consumo por Asignado';
                }

                if (hayDatos) {
                    crearTabla(tablaId, datosParaMostrar, columnas);
                    
                    // Mostrar botones de exportación
                    document.querySelectorAll('#btnExportarPDF, #btnExportarExcel').forEach(btn => btn.classList.remove('d-none'));
                } else {
                    // Mostrar mensaje si no hay datos
                    sinDatos.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error al cargar los datos:', error);
                const indicadorCarga = document.getElementById('indicadorCarga');
                if (indicadorCarga) indicadorCarga.remove();
                sinDatos.classList.remove('d-none');
            });
    });

    document.getElementById('btnExportarPDF').addEventListener('click', function () {
        try {
            // Verificar si jsPDF está cargado
            if (typeof window.jspdf === 'undefined') {
                alert("La biblioteca jsPDF no está cargada. Por favor, espere unos segundos y vuelva a intentarlo.");
                return;
            }

            const { jsPDF } = window.jspdf;
            let doc = new jsPDF();

            let tipo = document.getElementById('tipoReporte').value;
            let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
            let tabla = document.getElementById(tablaId).querySelector("table");

            if (!tabla) {
                alert("No hay datos para exportar.");
                return;
            }

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
        } catch (error) {
            console.error("Error al exportar a PDF:", error);
            alert("Ocurrió un error al exportar a PDF. Verifica la consola para más detalles.");
        }
    });

    document.getElementById('btnExportarExcel').addEventListener('click', function () {
        try {
            // Verificar si XLSX está cargado
            if (typeof XLSX === 'undefined') {
                alert("La biblioteca XLSX no está cargada. Por favor, espere unos segundos y vuelva a intentarlo.");
                return;
            }

            let tipo = document.getElementById('tipoReporte').value;
            let tablaId = `tablaConsumo${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`;
            let tabla = document.getElementById(tablaId).querySelector("table");
            
            if (!tabla) {
                alert("No hay datos para exportar.");
                return;
            }
            
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
        } catch (error) {
            console.error("Error al exportar a Excel:", error);
            alert("Ocurrió un error al exportar a Excel. Verifica la consola para más detalles.");
        }
    });
});
</script>
@endsection