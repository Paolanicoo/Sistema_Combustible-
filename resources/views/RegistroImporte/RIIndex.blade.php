@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}}

@section('titulo', 'index registro de combustible') {{-- Título de la página --}}

@section('contenido') {{-- Contenido de la página --}}

<!--asegura que los mensajes de alerta se muestren -->
@include('sweetalert::alert')

<style>
    body {
        font-family: 'Poppins', sans-serif; /* Fuente Poppins para todo el cuerpo */
        background-color: #f8f9fa; /* Color de fondo claro */
    }
    
    .container {
        max-width: 1240px; /* Ancho máximo de la contenedor */
        width: 100%; /* Ancho completo */
        margin: 0 auto; /* Centrado automático */
    }
    
    .dataTables_filter {
        margin-bottom: 20px; /* Espacio debajo del filtro de búsqueda */
    }
    
    .dataTables_filter input {
        border: 1px solid #e2e8f0; /* Borde gris claro */
        border-radius: 6px; /* Bordes redondeados */
        padding: 0.5rem 1rem; /* Espaciado interno */
        width: 250px; /* Ancho del campo de búsqueda */
    }
    
    .dataTables_filter input:focus {
        border-color: #3b82f6; /* Color de borde al enfocar */
        outline: none; /* Sin contorno */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra azul al enfocar */
    }
    
    /* Estilos para la tarjeta principal */
    .card {
        border-radius: 12px; /* Bordes redondeados */
        border: none;  /* Sin borde */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra suave */
        overflow: hidden; /* Evita que el contenido se desborde */
    }
    
    .card-header {
        background-color: rgb(226, 228, 230); /* Color de fondo del encabezado */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);  /* Borde inferior suave */
        padding: 1.5rem; /* Espaciado interno */
    }
    
    .card-title {
        color: #344767; /* Color del título */
        font-weight: 600; /* Peso de la fuente */
    }
    
    /* Estilos para los botones */
    .btn-info, .btn-nuevo-registro {
        background-color: #0ea5e9; /* Color de fondo azul */
        border-color: #0ea5e9; /* Color del borde azul */
        color: white; /* Color del texto */
        border-radius: 8px; /* Bordes redondeados */
        padding: 0.5rem 1rem; /* Espaciado interno */
        font-weight: 500; /* Peso de la fuente */
        transition: all 0.3s ease; /* Transición suave para hover */
    }
    
    .btn-info:hover, .btn-nuevo-registro:hover {
        background-color: #0284c7; /* Color de fondo al pasar el cursor */ 
        border-color: #0284c7; /* Color de fondo y borde al pasar el cursor */ 
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba al pasar el cursor */
        color: white; /* Color del texto al pasar el cursor */
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100% !important; /* Asegura que la tabla ocupe todo el ancho disponible */
        border-collapse: separate; /* Colapsar bordes */
        border-spacing: 0; /* Espaciado entre celdas */
    }
    
    .table thead th {
        color: #64748b; /* Color del texto del encabezado */
        font-weight: 600; /* Peso de la fuente del encabezado */
        font-size: 0.875rem; /* Tamaño de fuente del encabezado */
        padding: 12px; /* Espaciado interno del encabezado */
        border-bottom: 1px solid #e2e8f0; /* Borde inferior del encabezado */
        background-color: #f8fafc; /* Color de fondo del encabezado */
        white-space: nowrap; /* Evita que el texto se divida en varias líneas */
    }
    
    .table tbody td {
        padding: 12px; /* Espaciado interno de las celdas */
        vertical-align: middle; /* Alineación vertical al centro */
        border-bottom: 1px solid #f1f5f9; /* Borde inferior de las celdas */
        font-size: 0.875rem; /* Tamaño de fuente de las celdas */
        color: #334155; /* Color del texto de las celdas */
    }
    
    .table tbody tr:hover {
        background-color: #f1f5f9; /* Color de fondo al pasar el cursor sobre una fila */
    }
    
    /* Reducir ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px; /* Ancho fijo para la columna de acciones */
        text-align: center; /* Centrar el contenido de la columna */
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;    
        justify-content: center; 
        gap: 5px;
    }
    
    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem; /* Espaciado interno de los botones */
        border-radius: 6px; /* Bordes redondeados */
        font-size: 0.75rem; /* Tamaño de fuente de los botones */
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important; /* Bordes redondeados para los botones de paginación */
        margin: 0 2px !important; /* Espacio entre los botones de paginación */
    }
    
    .dataTables_paginate .paginate_button.current {
        background: #0ea5e9 !important; /* Color de fondo del botón actual */
        border-color: #0ea5e9 !important; /* Color del borde del botón actual */
        color: white !important; /* Color del texto del botón actual */
    }
    
    .dataTables_paginate .paginate_button:hover {
        background: #e2e8f0 !important; /* Color de fondo al pasar el cursor */
        border-color: #e2e8f0 !important; /* Color del borde al pasar el cursor */
        color: #334155 !important; /* Color del texto al pasar el cursor */
    }
    
    .dataTables_info {
        color: #64748b; /* Color del texto de información */
        padding-top: 1rem; /* Espaciado superior */
    }

    .btn-nuevo-registro {
        background-color: #0ea5e9; /* Color de fondo azul */
        border-color: #0ea5e9; /* Color del borde azul */
        color: white; /* Color del texto */
        font-weight: 600; /* Peso de la fuente */
        transition: all 0.3s ease; /* Transición suave para hover */
        padding: 0.75rem 1rem; /* Espaciado interno */
        font-size: 0.80rem; /* Tamaño de fuente */
        border-radius: 8px; /* Bordes redondeados */
        min-width: 160px; /* Ancho mínimo del botón */
        text-align: center; /* Alinear el texto al centro */
    }

    .btn-nuevo-registro:hover {
        background-color: #0284c7; /* Color de fondo al pasar el cursor */
        border-color: #0284c7; /* Color del borde al pasar el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba al pasar el cursor */
    }

    /* Efecto al pasar el cursor sobre los botones */
    .btn-info:hover, .btn-warning:hover, .btn-danger:hover {
        color: #000000; /* El texto se pondrá negro */
        transform: translateY(-2px); /* Los botones se moverán ligeramente hacia arriba */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Agrega una sombra para resaltar */
    }

    /* Estilos para el botón de "editar" */
    .btn-warning {
        background-color: #f59e0b; 
        border-color: #f59e0b;
        color: white; /*Color blanco*/ 
    }

    /* Estilos para el botón de "eliminar" */
    .btn-danger {
        background-color: #ef4444;  
        border-color: #ef4444;
        color: white; 
    }
</style>

<!--Encabezado de la pagina.-->
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b>Resumen de importes</b>
            </h2>
            @if(Auth::user()->role !== 'Visualizador')
                <a href="{{ route('registroimporte.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Tabla para mostrar los registros de importes. -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="importes-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Fecha</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Asignado</th>
                            <th>N° de factura</th>
                            <th>Consumo</th>
                            <th>Precio</th>
                            <th>Importe</th>
                            <th>Empresa</th>
                            <th>Tipo</th>
                            <th class="acciones-columna">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Fin del contenedor principal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#importes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('registroimporte.table') }}',
                type: 'GET'
            },
            columns: [
                {data: 'mes', name: 'mes'},
                {data: 'fecha', name: 'fecha'},
                {data: 'equipo', name: 'equipo'},
                {data: 'marca', name: 'marca'},
                {data: 'placa', name: 'placa'},
                {data: 'asignado', name: 'asignado'},
                {data: 'num_factura', name: 'num_factura'},
                {data: 'consumo', name: 'consumo'},
                {data: 'precio', name: 'precio'},
                {data: 'total', name: 'total'},
                {data: 'empresa', name: 'empresa'},
                {data: 'tipo', name: 'tipo'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'acciones-columna'}
            ],
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
                },
                "aria": {
                    "sortAscending": "Activar para ordenar la columna de manera ascendente",
                    "sortDescending": "Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>
@endsection

