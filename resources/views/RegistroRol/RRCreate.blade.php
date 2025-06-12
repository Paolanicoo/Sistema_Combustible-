@extends('Layouts.app')

@section('titulo', 'Gestión de Roles')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren. -->
@include('sweetalert::alert')

<style>
    body { /* Estilo para el cuerpo del documento. */
        font-family: 'Poppins', sans-serif; /*Fuente personalizada.*/
        background-color: #f8f9fa;/* Color de fondo.*/
    }

    .container { /*Estilo para el contenedor principal.*/
        max-width: 1240px;/* Ancho máximo.*/
    }

    .dataTables_filter { /*Filtro de búsqueda de DataTables.*/
        margin-bottom: 20px; /*Margen inferior.*/
    }

    .dataTables_filter input { /* Estilo para el campo de búsqueda. */
        border: 1px solid #e2e8f0; /* Borde gris claro. */
        border-radius: 6px; /* Bordes redondeados. */
        padding: 0.5rem 1rem; /* Padding interno. */
        width: 250px; /* Ancho del campo de búsqueda. */
    }

    .dataTables_filter input:focus { /* Estilo al enfocar el campo de búsqueda. */
        border-color: #3b82f6; /* Color del borde al enfocar. */
        outline: none; /* Sin contorno. */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra azul al enfocar. */
    }

    .card { /* Estilo para las tarjetas. */
        border-radius: 12px; /* Bordes redondeados. */
        border: none; /* Sin borde. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra suave. */
        overflow: hidden; /* Oculta el desbordamiento. */
    }
    .card-title { /* Estilo para el título de la tarjeta. */
        color: #344767; /* Color del texto. */
        font-weight: 600; /* Peso de la fuente. */
    }

    .card-header { /* Estilo para la cabecera de la tarjeta. */
        background-color: rgb(226, 228, 230); /* Color de fondo gris claro. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior suave. */
        padding: 1.5rem; /* Padding interno. */
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
        color: #334155; /* Color del texto. */
    }

     .table tbody tr:hover { /* Estilo al pasar el mouse sobre las filas de la tabla. */
        background-color: #f1f5f9; /* Color de fondo al pasar el mouse. */
    }
    .acciones-columna { /* Estilo para la columna de acciones. */
        width: 120px; /* Ancho de la columna. */
        text-align: center; /* Alinear texto al centro. */
    }

    .acciones-columna div { /* Estilo para el contenedor de botones en la columna de acciones. */
        display: flex; /* Usar flexbox. */
        justify-content: center; /* Centrar horizontalmente. */
        gap: 5px; /* Espacio entre botones. */
    }
    #roles-table tr td:nth-child(2),  /* Estilo para la segunda columna de la tabla de roles. */
    #roles-table tr th:nth-child(2),  /* Estilo para la segunda cabecera de la tabla de roles. */
    #roles-table th.acciones-columna,  /* Estilo para la cabecera de acciones en la tabla de roles. */
    #roles-table td.acciones-columna { /* Estilo para las celdas de acciones en la tabla de roles. */
        text-align: center !important; /* Alinear texto al centro, forzado. */
    }

    .dataTables_paginate .paginate_button { /* Estilo para los botones de paginación. */
        border-radius: 6px !important; /* Bordes redondeados, forzado. */
        margin: 0 2px !important; /* Margen entre botones, forzado. */
    }
    .dataTables_paginate .paginate_button.current { /* Estilo para el botón de paginación actual. */
        background: #0ea5e9 !important; /* Color de fondo azul. */
        border-color: #0ea5e9 !important; /* Color del borde azul. */
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

    .rol-columna { /* Estilo para la columna de rol. */
        text-align: left !important; /* Alinear texto a la izquierda, forzado. */
    }
    .toggleEstado { /* Estilo para el botón de alternar estado. */
        transition: all 0.3s ease; /* Transición suave para todos los cambios. */
        font-weight: 500; /* Peso de la fuente. */
    }
    .toggleEstado:hover { /* Estilo al pasar el mouse sobre el botón de alternar estado. */
        color: #000000; /* Cambia el color del texto a negro. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
    }

    /* Nueva clase para botones más pequeños. */
    .btn { /* Estilo para botones. */
        padding: 0.25rem 0.6rem; /* Padding interno reducido. */
        font-size: 0.8rem; /* Tamaño de la fuente reducido. */
        border-radius: 6px; /* Bordes redondeados. */
        font-weight: 500; /* Peso de la fuente. */
    }
</style>

<div class="container mt-5"> <!-- Contenedor con margen superior de Bootstrap. -->
    <div class="card"> <!-- Tarjeta de Bootstrap para encapsular el contenido. -->
        <div class="card-header d-flex justify-content-between align-items-center"> <!-- Encabezado de la tarjeta. -->
            <h2 class="card-title mb-0">
                <b>Registro de roles</b> <!-- Título del encabezado. -->
            </h2>
        </div>
        <div class="card-body p-4"> <!-- Cuerpo de la tarjeta con padding. -->
            <div class="table-responsive mt-3"> <!-- Contenedor responsivo para la tabla. -->
                <table class="table table-bordered table-striped w-100" id="roles-table"> <!-- Tabla con bordes, rayas y ancho completo. -->
                    <thead>
                        <tr>
                            <th class="rol-columna">Rol</th>   <!-- Encabezado columna Rol. -->
                            <th class="estado-columna">Estado</th> <!-- Encabezado columna Estado. -->
                            <th class="acciones-columna">Acciones</th> <!-- Encabezado columna Acciones. -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {  //Ejecuta cuando el DOM está completamente cargado. 
    let table = $('#roles-table').DataTable({ //Inicializa DataTables .
        processing: true, //Activa el indicador de procesamiento.
        serverSide: true, //Usa procesamiento del lado del servidor.
        ajax: '{{ route('registrorol.table') }}', //Ruta que retorna los datos de la tabla .
        columns: [ //Define las columnas de la tabla.
            {data: 'rol', name: 'rol'}, // Columna rol.
            {data: 'estado_texto', name: 'estado_texto', orderable: false, searchable: false}, //Columna estado (no ordenable ni buscable).
            {data: 'acciones', name: 'acciones', orderable: false, searchable: false} //Columna acciones (no ordenable ni buscable).
        ],
        searching: true, //Habilita el campo de búsqueda.
        paging: true, //Habilita la paginación.
        language: { // Traducción al español.
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
            
        },
        lengthChange: true //Permite cambiar la cantidad de filas por página.
    });

   // Evento para cambiar el estado con AJAX.
    $('#roles-table').on('click', '.toggleEstado', function() { //Evento click para cambiar estado del rol.
        let button = $(this); //Obtiene el botón.
        let roleId = button.data('id'); //Obtiene el ID del rol.
        let newEstado = button.data('estado') == 1 ? 0 : 1; //Cambia el estado.
        let accion = newEstado == 1 ? 'activar' : 'desactivar'; //Acción en texto.
        let mensaje = newEstado == 1 ? 'activado' : 'desactivado'; //Mensaje de confirmación.
        //Alerta de confirmación usando SweetAlert.
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas ${accion} este rol?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => { //Ejecuta si el usuario confirma.
            if (result.isConfirmed) {
                $.ajax({ //Petición AJAX para cambiar el estado.
                    url: "{{ route('roles.toggleEstado') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: roleId,
                        estado: newEstado // Nuevo estado.
                    },
                    success: function(response) { //Si la petición es exitosa.
                        if (response.success) {
                            Swal.fire(
                                '¡Listo!',
                                `El rol ha sido ${mensaje} correctamente.`,
                                'success'
                            );
                            table.ajax.reload(); // Recarga la tabla automáticamente.
                        } else {
                            Swal.fire(
                                'Error',
                                response.message || 'Ha ocurrido un error.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'Ha ocurrido un error en la operación.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

@endsection
