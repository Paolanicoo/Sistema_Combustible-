@extends('Layouts.app')

@section('titulo', 'Gestión de Registros Vehiculares')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<style>
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /* Tipo de fuente. */
        background-color: #f8f9fa; /* Color de fondo. */
    }
    
    /* Estilos para el contenedor */
    .container {
        max-width: 1240px; /* Ancho máximo del contenedor. */
    }
    
    /* Estilos para el filtro de búsqueda */
    .dataTables_filter {
        margin-bottom: 20px; /* Margen inferior del filtro. */
    }
    
    /* Estilos para el campo de búsqueda */
    .dataTables_filter input {
        border: 1px solid #e2e8f0; /* Borde del campo de búsqueda */
        border-radius: 6px; /* Radio de los bordes. */
        padding: 0.5rem 1rem; /* Relleno interno. */
        width: 250px; /* Ancho del campo de búsqueda */
    }
    
    /* Estilos para el campo de búsqueda cuando tiene el foco */
    .dataTables_filter input:focus {
        border-color: #3b82f6; /* Color del borde al enfocar. */
        outline: none; /* Sin contorno. */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra azul al enfocar. */
    }
    
    /* Estilos para la tarjeta principal */
    .card {
        border-radius: 12px; /* Radio de los bordes. */
        border: none; /* Sin borde. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra suave. */
        overflow: hidden; /* Evita que el contenido se desborde. */
    }
    
    /* Estilos para el título de la tarjeta */
    .card-title {
        color: #344767; /* Color del texto. */
        font-weight: 600; /* Peso del texto. */
    }

    /* Estilos para el encabezado de la tarjeta */
    .card-header {
        background-color: rgb(226, 228, 230); /* Color gris claro */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior. */
        padding: 1.5rem; /* Relleno interno. */
    }

    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem; /* Relleno interno. */
        border-radius: 6px; /* Radio de los bordes. */
        font-size: 0.75rem; /* Tamaño del texto. */
    }
    /* Estilos para los botones */
    .btn-info {
        background-color: #0ea5e9; /* Color de fondo. */
        border-color: #0ea5e9; /* Color del borde. */
        color: white; /* Color del texto. */
        font-weight: 500; /* Peso del texto. */
        transition: all 0.3s ease; /* Transición suave. */
        padding: 0.1rem 0.2rem; /* Ajuste moderado en el tamaño */
        font-size: 0.95rem; /* Ligera mejora en el tamaño del texto */
        border-radius: 8px; /* Mantiene bordes suaves */
    }
    
    .btn-info:hover {
        background-color: #0284c7; /* Color de fondo al pasar el cursor */
        border-color: #0284c7; /* Color del borde al pasar el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba al pasar el cursor */
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100%; /* Ancho de la tabla */
        border-collapse: separate; /* Separación de bordes */
        border-spacing: 0; /* Sin espacio entre celdas */
    }
    
    /* Estilos para las celdas de la tabla */
    .table thead th {
        color: #64748b; /* Color del texto. */
        font-weight: 600; /* Peso del texto. */
        font-size: 0.875rem; /* Tamaño del texto. */
        padding: 12px; /* Relleno interno. */
        border-bottom: 1px solid #e2e8f0; /* Borde inferior. */
        background-color: #f8fafc; /* Color de fondo. */
    }
    
    /* Estilos para las celdas de la tabla */
    .table tbody td {
        padding: 12px; /* Relleno interno. */
        vertical-align: middle; /* Alineación vertical. */
        border-bottom: 1px solid #f1f5f9; /* Borde inferior. */
        font-size: 0.875rem; /* Tamaño del texto. */
        color: #334155; /* Color del texto. */
    }
    
    /* Estilos para las filas de la tabla */
    .table tbody tr:hover {
        background-color: #f1f5f9; /* Color de fondo al pasar el cursor */
    }
    
    /* Reducir ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px; /* Ancho de la columna */
        text-align: center; /* Alineación horizontal */
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex; /* Mostrar los botones en una fila */
        justify-content: center; /* Alinear los botones al centro */
        gap: 5px; /* Espacio entre los botones */
    }
    
    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem; /* Relleno interno */
        border-radius: 6px; /* Radio de los bordes */
        font-size: 0.75rem; /* Tamaño del texto */
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important; /* Radio de los bordes */
        margin: 0 2px !important; /* Margen entre los botones */
    }
    
    /* Botones de paginación actual */
    .dataTables_paginate .paginate_button.current {
        background: #0ea5e9 !important; /* Color de fondo */
        border-color: #0ea5e9 !important; /* Color del borde */
        color: white !important; /* Color del texto */
    }
    
    /* Efecto al pasar el cursor sobre los botones de paginación */
    .dataTables_paginate .paginate_button:hover {
        background: #e2e8f0 !important; /* Color de fondo */
        border-color: #e2e8f0 !important; /* Color del borde */
        color: #334155 !important; /* Color del texto */
    }
    
    /* Información sobre los registros visibles en DataTables */
    .dataTables_info {
        color: #64748b; /* Color del texto */
        padding-top: 1rem; /* Margen superior */
    }

    /* Botón personalizado para agregar nuevo registro */
    .btn-nuevo-registro {
        background-color: #0ea5e9; /* Color de fondo */
        border-color: #0ea5e9; /* Color del borde */
        color: white; /* Color del texto */
        font-weight: 600; /* Peso del texto */
        transition: all 0.3s ease; /* Transición suave */
        padding: 0.75rem 1rem; /* Relleno interno */
        font-size: 0.80rem; /* Tamaño del texto */
        border-radius: 8px; /* Radio de los bordes */
        min-width: 160px; /* Ancho mínimo */
        text-align: center; /* Alineación horizontal */
    }

    /* Efecto al pasar el cursor sobre el botón */
    .btn-nuevo-registro:hover {
        background-color: #0284c7; /* Color de fondo al pasar el cursor */
        border-color: #0284c7; /* Color del borde al pasar el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba al pasar el cursor */
    }

    /* Estilos para los botones de ver, editar y eliminar */
    .btn-warning, .btn-danger {
        border-radius: 8px; /* Radio de los bordes */
        padding: 0.25rem 0.5rem; /* Relleno interno */
        font-size: 0.85rem; /* Tamaño del texto */
        font-weight: 500; /* Peso del texto */
        transition: all 0.3s ease; /* Transición suave */
    }

    /* Efecto al pasar el cursor sobre los botones */
    .btn-warning:hover, .btn-danger:hover {
        color: #000000; /* El texto se pondrá negro */
        transform: translateY(-2px); /* Los botones se moverán ligeramente hacia arriba */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Agrega una sombra para resaltar */
    }

    /* Estilos para el botón de "editar" */
    .btn-warning {
        background-color: #f59e0b; /* Color de fondo */
        border-color: #f59e0b; /* Color del borde */
        color: white; /* Color del texto */
    }

    /* Estilos para el botón de "eliminar" */
    .btn-danger {
        background-color: #ef4444; /* Color de fondo */
        border-color: #ef4444; /* Color del borde */
        color: white; /* Color del texto */
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Título centrado con fondo gris claro -->
            <h2 class="card-title mb-0">
                </i><b>Registro vehicular</b>
            </h2>
            @if(Auth::user()->role !== 'Visualizador')
            <!-- Botón para agregar nuevo registro -->
                <a href="{{ route('registrovehicular.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <!-- Cuerpo de la tarjeta con el contenido de la tabla -->
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
                // Columna de acciones
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