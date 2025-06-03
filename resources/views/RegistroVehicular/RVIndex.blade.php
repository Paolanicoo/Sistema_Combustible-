@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}}

@section('titulo', 'Gestión de Registros Vehiculares') {{-- Título de la página --}}

@section('contenido') {{-- Contenido de la página --}}

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert') {{-- Incluye el paquete de alertas --}}

<style>
    /* Estilo base */
    body {
        font-family: 'Poppins', sans-serif; /* Tipo de fuente. */
        background-color: #f8f9fa; /* Color de fondo. */
    }
    
    /* Estilo del contenedor */
    .container {
        max-width: 1240px; /* Ancho máximo del contenedor. */
    }
    
    /* Estilo del filtro */
    .dataTables_filter {
        margin-bottom: 20px; /* Margen inferior del filtro. */
    }
    
    /* Estilo del input del filtro */
    .dataTables_filter input {
        border: 1px solid #e2e8f0; /* Borde del filtro. */
        border-radius: 6px; /* Radio del borde del filtro. */
        padding: 0.5rem 1rem; /* Padding interno del filtro. */
        width: 250px; /* Ancho del filtro. */
    }
    
    /* Estilo del input del filtro al enfocarse */
    .dataTables_filter input:focus {
        border-color: #3b82f6; /* Borde del filtro al enfocarse. */
        outline: none; /* Elimina el borde de enfocarse. */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra del filtro al enfocarse. */
    }
    
    /* Estilos para la tarjeta principal */
    .card {
        border-radius: 12px; /* Radio del borde de la tarjeta. */
        border: none; /* Elimina el borde de la tarjeta. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra de la tarjeta. */
        overflow: hidden; /* Oculta el contenido que excede el tamaño de la tarjeta. */
    }
    
    /* Estilo del título de la tarjeta */
    .card-title {
        color: #344767; /* Color del título de la tarjeta. */
        font-weight: 600; /* Peso del título de la tarjeta. */
    }

    /* Estilo del encabezado de la tarjeta */
    .card-header {
        background-color: rgb(226, 228, 230); /* Color gris claro */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior del encabezado de la tarjeta. */
        padding: 1.5rem; /* Padding interno del encabezado de la tarjeta. */
    }

    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem; /* Padding interno del botón. */
        border-radius: 6px; /* Radio del borde del botón. */
        font-size: 0.75rem; /* Tamaño del texto del botón. */
    }
    /* Estilos para los botones */
    .btn-info {
        background-color: #0ea5e9; /* Color de fondo del botón. */
        border-color: #0ea5e9; /* Color del borde del botón. */
        color: white; /* Color del texto del botón. */
        font-weight: 500; /* Peso del texto del botón. */
        transition: all 0.3s ease; /* Transición suave al cambiar el estado del botón. */
        padding: 0.1rem 0.2rem; /* Ajuste moderado en el tamaño */
        font-size: 0.95rem; /* Ligera mejora en el tamaño del texto */
        border-radius: 8px; /* Mantiene bordes suaves */
    }
    
    /* Efecto al pasar el cursor sobre los botones */
    .btn-info:hover {
        background-color: #0284c7; /* Color de fondo del botón al pasar el cursor. */
        border-color: #0284c7; /* Color del borde del botón al pasar el cursor. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra del botón al pasar el cursor. */
        transform: translateY(-2px); /* Movimiento del botón al pasar el cursor. */
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100%; /* Ancho de la tabla. */
        border-collapse: separate; /* Fusiona las celdas de la tabla. */
        border-spacing: 0; /* Espacio entre las celdas de la tabla. */
    }
    
    /* Estilo de los encabezados de la tabla */
    .table thead th {
        color: #64748b; /* Color del texto del encabezado de la tabla. */
        font-weight: 600; /* Peso del texto del encabezado de la tabla. */
        font-size: 0.875rem; /* Tamaño del texto del encabezado de la tabla. */
        padding: 12px; /* Padding interno del encabezado de la tabla. */
        border-bottom: 1px solid #e2e8f0; /* Borde inferior del encabezado de la tabla. */
        background-color: #f8fafc; /* Color de fondo del encabezado de la tabla. */
    }
    
    /* Estilo de las celdas de la tabla */
    .table tbody td {
        padding: 12px; /* Padding interno de las celdas de la tabla. */
        vertical-align: middle; /* Alineación vertical al centro. */
        border-bottom: 1px solid #f1f5f9; /* Borde inferior de las celdas de la tabla. */
        font-size: 0.875rem; /* Tamaño del texto de las celdas de la tabla. */
        color: #334155; /* Color del texto de las celdas de la tabla. */
    }
    
    /* Cambia el color de fondo al pasar el cursor sobre una fila */
    .table tbody tr:hover {
        background-color: #f1f5f9; /* Color de fondo al pasar el cursor sobre una fila. */
    }
    
    /* Reducir ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px; /* Ancho de la columna de acciones. */
        text-align: center; /* Alineación horizontal al centro. */
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex; /* Muestra los botones como bloques. */
        justify-content: center; /* Alineación horizontal al centro. */
        gap: 5px; /* Espacio entre los botones. */
    }
    
    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem; /* Padding interno del botón. */
        border-radius: 6px; /* Radio del borde del botón. */
        font-size: 0.75rem; /* Tamaño del texto del botón. */
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important; /* Radio del borde del botón. */
        margin: 0 2px !important; /* Margen entre los botones. */
    }
    
    /* Botones de paginación */
    .dataTables_paginate .paginate_button.current {
        background: #0ea5e9 !important; /* Color de fondo del botón actual. */
        border-color: #0ea5e9 !important; /* Color del borde del botón actual. */
        color: white !important; /* Color del texto del botón actual. */
    }
    
    /* Efecto al pasar el cursor sobre los botones de paginación */
    .dataTables_paginate .paginate_button:hover {
        background: #e2e8f0 !important; /* Color de fondo al pasar el cursor sobre los botones de paginación. */
        border-color: #e2e8f0 !important; /* Color del borde al pasar el cursor sobre los botones de paginación. */
        color: #334155 !important; /* Color del texto al pasar el cursor sobre los botones de paginación. */
    }
    
    /* Información de la tabla */
    .dataTables_info {
        color: #64748b; /* Color del texto de la información de la tabla. */
        padding-top: 1rem; /* Padding superior de la información de la tabla. */
    }

    /* Botones de acción */
    .btn-nuevo-registro {
        background-color: #0ea5e9; /* Color de fondo del botón. */
        border-color: #0ea5e9; /* Color del borde del botón. */
        color: white; /* Color del texto del botón. */
        font-weight: 600; /* Peso del texto del botón. */
        transition: all 0.3s ease; /* Transición suave al cambiar el estado del botón. */
        padding: 0.75rem 1rem; /* Padding interno del botón. */
        font-size: 0.80rem; /* Tamaño del texto del botón. */
        border-radius: 8px; /* Radio del borde del botón. */
        min-width: 160px; /* Ancho mínimo del botón. */
        text-align: center; /* Alineación horizontal al centro. */
    }

    /* Efecto al pasar el cursor sobre el botón */
    .btn-nuevo-registro:hover {
        background-color: #0284c7; /* Color de fondo al pasar el cursor. */
        border-color: #0284c7; /* Color del borde al pasar el cursor. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba al pasar el cursor. */
    }

    /* Estilos para los botones de ver, editar y eliminar */
    .btn-warning, .btn-danger {
        border-radius: 8px; /* Radio del borde del botón. */
        padding: 0.25rem 0.5rem; /* Padding interno del botón. */
        font-size: 0.85rem; /* Tamaño del texto del botón. */
        font-weight: 500; /* Peso del texto del botón. */
        transition: all 0.3s ease; /* Transición suave al cambiar el estado del botón. */
    }

    /* Efecto al pasar el cursor sobre los botones */
    .btn-warning:hover, .btn-danger:hover {
        color: #000000; /* El texto se pondrá negro */
        transform: translateY(-2px); /* Los botones se moverán ligeramente hacia arriba */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Agrega una sombra para resaltar */
    }

    /* Estilos para el botón de "editar" */
    .btn-warning {
        background-color: #f59e0b; /* Color de fondo del botón. */
        border-color: #f59e0b; /* Color del borde del botón. */
        color: white; /* Color del texto del botón. */
    }

    /* Estilos para el botón de "eliminar" */
    .btn-danger {
        background-color: #ef4444; /* Color de fondo del botón. */
        border-color: #ef4444; /* Color del borde del botón. */
        color: white; /* Color del texto del botón. */
    }

</style>

@section('contenido')
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Título e ícono para agregar nuevo registro -->
            <h2 class="card-title mb-0">
                <i class="fas fa-car"></i><b>Registro vehicular</b>
            </h2>
            <!-- Botón para agregar nuevo registro -->
            @if(Auth::user()->role !== 'Visualizador')
                <a href="{{ route('registrovehicular.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <!-- Cuerpo de la tarjeta -->
        <div class="card-body p-4">
            <div class="table-responsive mt-3">
                <!-- Tabla de vehículos -->
                <table class="table table-bordered table-striped w-100" id="vehiculos-table">
                    <thead>
                        <tr>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Motor</th>
                            <th>Serie</th>
                            <th>Asignado</th>
                            <th>Observación</th>
                            <th class="acciones-columna text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Script para la tabla de vehículos -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#vehiculos-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('registrovehicular.table') }}',
            columns: [
                { data: 'equipo', name: 'equipo' },
                { data: 'marca', name: 'marca' },
                { data: 'placa', name: 'placa' },
                { data: 'modelo', name: 'modelo' },
                { data: 'motor', name: 'motor' },
                { 
                    data: 'serie', 
                    name: 'serie', 
                    render: function(data) { 
                        return data ? data.substring(0, 6) : ''; 
                    } 
                },
                { data: 'asignado', name: 'asignado' },
                { 
                    data: 'observacion', 
                    name: 'observacion', 
                    render: function(data) { 
                        return data ? data.substring(0, 6) : ''; 
                    } 
                },
                // Columna de Acciones
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'acciones-columna' }
            ],
            // Configuración de idioma
            language: {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>

@endsection