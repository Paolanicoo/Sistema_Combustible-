@extends('Layouts.app')

@section('titulo', 'User')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<style>
    body { /* Estilos para el cuerpo de la página */
        font-family: 'Poppins', sans-serif; /* Fuente utilizada */
        background-color: #f8f9fa; /* Color de fondo */
    }
   .container { /* Estilos para el contenedor principal */
        max-width: 1240px; /* Ancho máximo del contenedor */
    }
    .dataTables_filter { /* Estilos para el filtro de DataTables */
        margin-bottom: 20px; /* Margen inferior */
    }
    .dataTables_filter input { /* Estilos para el input del filtro */
        border: 1px solid #e2e8f0; /* Borde gris claro */
        border-radius: 6px; /* Bordes redondeados */
        padding: 0.5rem 1rem; /* Padding interno */
        width: 250px; /* Ancho del input */
    }
    
   .dataTables_filter input:focus { /* Estilos al enfocar el input del filtro */
        border-color: #3b82f6; /* Color del borde al enfocar */
        outline: none; /* Sin contorno */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra azul al enfocar */
    }
    
    .card { /* Estilos para la tarjeta */
        border-radius: 12px; /* Bordes redondeados */
        border: none; /* Sin borde */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra */
        overflow: hidden; /* Oculta el desbordamiento */
    }
    
    .card-title { /* Estilos para el título de la tarjeta */
        color: #344767; /* Color del texto */
        font-weight: 600; /* Peso de la fuente */
    }

    .card-header { /* Estilos para la cabecera de la tarjeta */
        background-color: rgb(226, 228, 230); /* Color gris claro */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior */
        padding: 1.5rem; /* Padding interno */
    }

    /* Botones de acción */
    .btn-sm { /* Estilos para botones pequeños */
        padding: 0.25rem 0.5rem; /* Padding interno */
        border-radius: 6px; /* Bordes redondeados */
        font-size: 0.75rem; /* Tamaño de la fuente */
    }
    
    /* Estilos para los botones */
    .btn-info { /* Estilos para el botón de información */
        background-color: #0ea5e9; /* Color de fondo azul */
        border-color: #0ea5e9; /* Color del borde azul */
        color: white; /* Color del texto blanco */
        font-weight: 500; /* Peso de la fuente */
        transition: all 0.3s ease; /* Transición suave */
        padding: 0.1rem 0.2rem; /* Ajuste moderado en el tamaño */
        font-size: 0.95rem; /* Ligera mejora en el tamaño del texto */
        border-radius: 8px; /* Mantiene bordes suaves */
    }
    
    .btn-info:hover { /* Estilos al pasar el mouse sobre el botón de información */
        background-color: #0284c7; /* Color de fondo azul oscuro */
        border-color: #0284c7; /* Color del borde azul oscuro */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba */
    }
    
    .table { /* Estilos para la tabla */
        width: 100%; /* Ancho completo */
        border-collapse: separate; /* Colapsar bordes separados */
        border-spacing: 0; /* Sin espaciado entre celdas */
    }
    
    .table thead th { /* Estilos para las celdas del encabezado de la tabla */
        color: #64748b; /* Color del texto */
        font-weight: 600; /* Peso de la fuente */
        font-size: 0.875rem; /* Tamaño de la fuente */
        padding: 12px; /* Padding interno */
        border-bottom: 1px solid #e2e8f0; /* Borde inferior */
        background-color: #f8fafc; /* Color de fondo */
    }
    
    .table tbody td { /* Estilos para las celdas del cuerpo de la tabla */
        padding: 12px; /* Padding interno */
        vertical-align: middle; /* Alinear verticalmente al medio */
        border-bottom: 1px solid #f1f5f9; /* Borde inferior */
        font-size: 0.875rem; /* Tamaño de la fuente */
        color: #334155; /* Color del texto */
    }
    
    .table tbody tr:hover { /* Estilos al pasar el mouse sobre las filas de la tabla */
        background-color: #f1f5f9; /* Color de fondo al pasar el mouse */
    }
    
    /* Reducir ancho de la columna "Acciones" */
    .acciones-columna { /* Estilos para la columna de acciones */
        width: 120px; /* Ancho de la columna */
        text-align: center; /* Alinear texto al centro */
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    /* Paginación */
    .dataTables_paginate .paginate_button { /* Estilos para los botones de paginación */
        border-radius: 6px !important; /* Bordes redondeados */
        margin: 0 2px !important; /* Margen entre botones */
    }
    
    .dataTables_paginate .paginate_button.current { /* Estilos para el botón de paginación actual */
        background: #0ea5e9 !important; /* Color de fondo azul */
        border-color: #0ea5e9 !important; /* Color del borde azul */
        color: white !important; /* Color del texto blanco */
    }
    
    .dataTables_paginate .paginate_button:hover { /* Estilos al pasar el mouse sobre los botones de paginación */
        background: #e2e8f0 !important; /* Color de fondo gris claro */
        border-color: #e2e8f0 !important; /* Color del borde gris claro */
        color: #334155 !important; /* Color del texto gris oscuro */
    }
    
    .dataTables_info { /* Estilos para la información de paginación */
        color: #64748b; /* Color del texto */
        padding-top: 1rem; /* Padding superior */
    }
    .btn-nuevo-registro { /* Estilos para el botón de nuevo registro */
        background-color: #0ea5e9; /* Color de fondo azul */
        border-color: #0ea5e9; /* Color del borde azul */
        color: white; /* Color del texto blanco */
        font-weight: 600; /* Peso de la fuente */
        transition: all 0.3s ease; /* Transición suave */
        padding: 0.75rem 1rem; /* Padding interno */
        font-size: 0.80rem; /* Tamaño de la fuente */
        border-radius: 8px; /* Bordes redondeados */
        min-width: 160px; /* Ancho mínimo del botón */
        text-align: center; /* Centrar texto */
    }

   .btn-nuevo-registro:hover { /* Estilos al pasar el mouse sobre el botón de nuevo registro */
        background-color: #0284c7; /* Color de fondo azul oscuro */
        border-color: #0284c7; /* Color del borde azul oscuro */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba */
    }
    /* Efecto al pasar el cursor sobre los botones */
    .btn-info:hover, .btn-warning:hover, .btn-danger:hover { /* Estilos para botones al pasar el mouse */
        color: #000000; /* El texto se pondrá negro */
        transform: translateY(-2px); /* Los botones se moverán ligeramente hacia arriba */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Agrega una sombra para resaltar */
    }
    /* Estilos para el botón de "editar" */
    .btn-warning { /* Estilos para el botón de advertencia */
        background-color: #f59e0b; /* Color de fondo amarillo */
        border-color: #f59e0b; /* Color del borde amarillo */
        color: white; /* Color del texto blanco */
    }

    /* Estilos para el botón de "eliminar" */
    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
    }
</style>

<div class="container mt-5"> <!-- Contenedor principal con margen superior -->
    <div class="card">  <!-- Tarjeta para contener el contenido -->
        <div class="card-header d-flex justify-content-between align-items-center"> <!-- Cabecera de la tarjeta con flexbox para alinear elementos -->
            <h2 class="card-title mb-0"> <!-- Título de la tarjeta -->
                <b>Registro de usuarios</b> <!-- Texto en negrita -->
            </h2>
           
            @if(Auth::user()->role !== 'Visualizador') <!-- Verifica si el usuario no es un visualizador -->
                <a href="{{ route('user.create') }}" class="btn btn-info btn-sm btn-nuevo-registro"> <!-- Botón para crear un nuevo registro -->
                    <i class="fas fa-plus"></i> Nuevo registro <!-- Icono y texto del botón -->
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mt-3"> <!-- Contenedor para la tabla, con margen superior -->
                <table class="table table-bordered table-striped w-100" id="users-table"> <!-- Tabla para mostrar usuarios -->
                    <thead> <!-- Encabezado de la tabla -->
                        <tr> <!-- Fila del encabezado -->
                            <th>Nombre</th>
                            <th>Rol</th>
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
    $(document).ready(function () { // Espera a que el DOM esté completamente cargado.
        $('#users-table').DataTable({ // Inicializa DataTable en la tabla de usuarios.
            processing: true, // Muestra el indicador de procesamiento.
            serverSide: true, // Habilita el procesamiento del lado del servidor
            ajax: '{{ route('user.table') }}', // URL para obtener los datos de la tabla.
            columns: [ // Definición de columnas.
                {data: 'name', name: 'name'},
                {data: 'role', name: 'role'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'acciones-columna'}
            ],
            language: { // Configuración de idioma para DataTable.
                "processing": "Procesando...", // Mensaje de procesamiento.
                "lengthMenu": "Mostrar _MENU_ registros", // Menú de longitud
                "zeroRecords": "No se encontraron resultados", // Mensaje cuando no hay registros.
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_", // Información de paginación.
                "search": "Buscar:",// Texto del campo de búsqueda.
                "paginate": { // Configuración de paginación
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