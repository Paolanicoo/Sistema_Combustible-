@extends('Layouts.app')

@section('titulo','Registro Combustible')

@section('contenido')

<!--Asegura que los mensajes de SweetAlert se muestren. -->
@include('sweetalert::alert') 

<style>
   body { /* Estilo para el cuerpo del documento. */
        font-family: 'Poppins', sans-serif; /* Fuente personalizada. */
        background-color: #f8f9fa; /* Color de fondo gris claro. */
    }
    
    .container { /* Estilo para el contenedor principal. */
        max-width: 1240px; /* Ancho máximo del contenedor. */
    }
    
    .dataTables_filter { /* Estilo para el filtro de búsqueda de DataTables. */
        margin-bottom: 20px; /* Margen inferior para el filtro. */
    }
    
    .dataTables_filter input { /* Estilo para el campo de búsqueda. */
        border: 1px solid #e2e8f0; /* Borde gris claro. */
        border-radius: 6px; /* Bordes redondeados .*/
        padding: 0.5rem 1rem; /* Padding interno. */
        width: 250px; /* Ancho del campo de búsqueda. */
    }
    
    .dataTables_filter input:focus { /* Estilo al enfocar el campo de búsqueda. */
        border-color: #3b82f6; /* Color del borde al enfocar. */
        outline: none; /* Sin contorno */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra azul al enfocar. */
    }
    
    /* Estilos para la tarjeta principal. */
    .card { /* Estilo para las tarjetas. */
        border-radius: 12px; /* Bordes redondeados. */
        border: none; /* Sin borde. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra suave. */
        overflow: hidden; /* Oculta el desbordamiento. */
    }
    
    .card-header { /* Estilo para la cabecera de la tarjeta. */
        background-color: #fff; /* Color de fondo blanco. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior suave. */
        padding: 1.5rem; /* Padding interno. */
    }
    
    .card-title { /* Estilo para el título de la tarjeta. */
        color: #344767; /* Color del texto. */
        font-weight: 600; /* Peso de la fuente. */
    }

    .card-header { /* Estilo para la cabecera de la tarjeta (duplicado). */
        background-color: rgb(226, 228, 230); /* Color gris claro. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior suave. */
        padding: 1.5rem; /* Padding interno. */
    }
    /* Estilos para los botones. */
    .btn-info { /* Estilo para el botón de información. */
        background-color: #0ea5e9; /* Color de fondo azul. */
        border-color: #0ea5e9; /* Color del borde azul. */
        color: white; /* Color del texto blanco. */
        border-radius: 8px; /* Bordes redondeados. */
        padding: 0.5rem 1rem; /* Padding interno. */
        font-weight: 500; /* Peso de la fuente. */
        transition: all 0.3s ease; /* Transición suave para todos los cambios. */
    }
    
    .btn-info:hover { /* Estilo al pasar el mouse sobre el botón de información. */
        background-color: #0284c7; /* Color de fondo azul oscuro. */
        border-color: #0284c7; /* Color del borde azul oscuro. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
    }
    
    .table { /* Estilo para las tablas. */
        width: 100%; /* Ancho completo. */
        border-collapse: separate; /* Colapsar bordes separados. */
        border-spacing: 0; /* Sin espaciado entre celdas. */
    }
    
    .table thead th { /* Estilo para las celdas del encabezado de la tabla. */
        color: #64748b; /* Color del texto. */
        font-weight: 600; /* Peso de la fuente. */
        font-size: 0.875rem; /* Tamaño de la fuente. */
        padding: 12px; /* Padding interno. */
        border-bottom: 1px solid #e2e8f0; /* Borde inferior. */
        background-color: #f8fafc; /* Color de fondo. */
    }
    
     .table tbody td { /* Estilo para las celdas del cuerpo de la tabla. */
        padding: 12px; /* Padding interno. */
        vertical-align: middle; /* Alinear verticalmente al medio. */
        border-bottom: 1px solid #f1f5f9; /* Borde inferior. */
        font-size: 0.875rem; /* Tamaño de la fuente. */
        color: #334155; /* Color del texto .*/
    }
    
    .table tbody tr:hover { /* Estilo al pasar el mouse sobre las filas de la tabla. */
        background-color: #f1f5f9; /* Color de fondo al pasar el mouse. */
    }
    
    /* Reducir ancho de la columna "Acciones" .*/
    .acciones-columna { /* Estilo para la columna de acciones .*/
        width: 120px; /* Ancho de la columna. */
        text-align: center; /* Alinear texto al centro. */
    }

    /* Centrar los botones en la columna de acciones. */
    .acciones-columna div { /* Estilo para el contenedor de botones en la columna de acciones. */
        display: flex; /* Usar flexbox. */
        justify-content: center; /* Centrar horizontalmente. */
        gap: 5px; /* Espacio entre botones. */
    }
    
    /* Botones de acción. */
    .btn-sm { /* Estilo para botones pequeños .*/
        padding: 0.25rem 0.5rem; /* Padding interno reducido. */
        border-radius: 6px; /* Bordes redondeados. */
        font-size: 0.75rem; /* Tamaño de la fuente reducido. */
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button { /* Estilo para los botones de paginación. */
        border-radius: 6px !important; /* Bordes redondeados, forzado .*/
        margin: 0 2px !important; /* Margen entre botones, forzado. */
    }
    
        .dataTables_paginate .paginate_button.current { /* Estilo para el botón de paginación actual. */
        background: #0ea5e9 !important; /* Color de fondo azul. */
        border-color: #0ea5e9 !important; /* Color del borde azul .*/
        color: white !important; /* Color del texto blanco. */
    }

    
   .dataTables_paginate .paginate_button:hover { /* Estilo al pasar el mouse sobre los botones de paginación. */
        background: #e2e8f0 !important; /* Color de fondo gris claro. */
        border-color: #e2e8f0 !important; /* Color del borde gris claro. */
        color: #334155 !important; /* Color del texto gris oscuro. */
    }
    
    .dataTables_info { /* Estilo para la información de paginación. */
        color: #64748b; /* Color del texto. */
        padding-top: 1rem; /* Padding superior. */
    }

    .btn-nuevo-registro { /* Estilo para el botón de nuevo registro. */
        background-color: #0ea5e9; /* Color de fondo azul. */
        border-color: #0ea5e9; /* Color del borde azul. */
        color: white; /* Color del texto blanco. */
        font-weight: 600; /* Peso de la fuente. */
        transition: all 0.3s ease; /* Transición suave para todos los cambios. */
        padding: 0.75rem 1rem; /* Padding interno. */
        font-size: 0.80rem; /* Tamaño de la fuente. */
        border-radius: 8px; /* Bordes redondeados. */
        min-width: 160px; /* Ancho mínimo del botón. */
        text-align: center; /* Centrar texto. */
    }

    .btn-nuevo-registro:hover { /* Estilo al pasar el mouse sobre el botón de nuevo registro. */
        background-color: #0284c7; /* Color de fondo azul oscuro. */
        border-color: #0284c7; /* Color del borde azul oscuro. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
    }

    /* Efecto al pasar el cursor sobre los botones. */
    .btn-info:hover, .btn-warning:hover, .btn-danger:hover {
        color: #000000; /* El texto se pondrá negro. */
        transform: translateY(-2px); /* Los botones se moverán ligeramente hacia arriba. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Agrega una sombra para resaltar. */
    }

    /* Estilos para el botón de "editar". */
    .btn-warning { /* Estilo para el botón de advertencia. */
        background-color: #f59e0b; /* Color de fondo amarillo. */
        border-color: #f59e0b; /* Color del borde amarillo. */
        color: white; /* Color del texto blanco. */
    }
    /* Estilos para el botón de "eliminar". */
    .btn-danger { /* Estilo para el botón de peligro. */
        background-color: #ef4444; /* Color de fondo rojo. */
        border-color: #ef4444; /* Color del borde rojo .*/
        color: white; /* Color del texto blanco. */
    }
</style>

<div class="container mt-5"> <!-- Contenedor con margen superior.-->  
    <div class="card"> <!-- Tarjeta que contiene el contenido principal.-->
        <div class="card-header d-flex justify-content-between align-items-center"> <!--Encabezado con título y botón. -->
            <h2 class="card-title mb-0">
                <b>Registro de combustible</b>  <!-- Título-->
            </h2>
            @if(Auth::user()->role !== 'Visualizador')  <!--Solo usuarios que no son 'Visualizador' pueden ver el botón.  -->
                <a href="{{ route('registrocombustible.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                    <i class="fas fa-plus"></i> Nuevo registro  <!-- Botón para crear un nuevo registro.-->
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mt-3">  <!--Tabla adaptable a pantallas pequeñas. -->
                <table class="table table-bordered table-striped w-100" id="combustible-table">  <!-- Tabla de DataTables.-->
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Asignado</th>
                            <th>N° de factura</th>
                            <th>Entrada galones</th>
                            <th>Salida galones</th>
                            <th>Observación</th> 
                            <th class="acciones-columna text-center">Acciones</th> <!-- Centrado y ancho ajustado. -->
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
    $(document).ready(function () {  // Ejecuta cuando el DOM esté completamente cargado.
        $('#combustible-table').DataTable({ // Inicializa la tabla como DataTable.
            processing: true, // Muestra indicador de carga.
            serverSide: true, // Activar procesamiento del lado del servidor.
            ajax: '{{ route('registrocombustible.getTableData') }}', // Ruta que entrega los datos vía JSON.
            columns: [ // Columnas esperadas desde el backend.
                {data: 'fecha', name: 'fecha'},
                {data: 'vehiculo_equipo', name: 'vehiculo_equipo'},
                {data: 'vehiculo_marca', name: 'vehiculo_marca'},
                {data: 'vehiculo_placa', name: 'vehiculo_placa'},
                {data: 'vehiculo_asignado', name: 'vehiculo_asignado'},
                {data: 'num_factura', name: 'num_factura'},
                {data: 'entradas', name: 'entradas'},
                {data: 'salidas', name: 'salidas'},
                {data: 'observacion', name: 'observacion'}, 
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'acciones-columna'}
            ],
            language: { // Traducción al español.
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