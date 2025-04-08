@extends('Layouts.app')

@section('titulo', 'Gestión de Roles')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    
    .container {
        max-width: 1240px;
    }
    
    .dataTables_filter {
        margin-bottom: 20px;
    }
    
    .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        width: 250px;
    }
    
    .dataTables_filter input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
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

    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }
    
    /* Estilos para los botones */
    .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 0.1rem 0.2rem; /* Ajuste moderado en el tamaño */
        font-size: 0.95rem; /* Ligera mejora en el tamaño del texto */
        border-radius: 8px; /* Mantiene bordes suaves */
    }
    
    .btn-info:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table thead th {
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    
    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        color: #334155;
    }
    
    .table tbody tr:hover {
        background-color: #f1f5f9;
    }
    
    /* Ajustar el ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px;
        text-align: center;
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;
        justify-content: center;
        gap: 5px;
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
    
    /* Estilo específico para las columnas de rol y estado */
    .rol-columna, .estado-columna {
        text-align: center;
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b>Registro de roles</b>
            </h2>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="roles-table">
                    <thead>
                        <tr>
                            <th>Rol</th>  
                            <th>Estado</th>
                            <th class="acciones-columna text-center">Acciones</th>        
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    let table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('registrorol.table') }}',
        columns: [
            {data: 'rol', name: 'rol'},
            {data: 'estado_texto', name: 'estado_texto', orderable: false, searchable: false},
            {data: 'acciones', name: 'acciones', orderable: false, searchable: false}
        ],
        searching: false, // Desactiva la barra de búsqueda
        paging: true, // Desactiva la paginación
        language: {
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
            
        },
        lengthChange: false // Oculta la opción de cambiar el número de registros mostrados
    });

   // Evento para cambiar el estado con AJAX
    $('#roles-table').on('click', '.toggleEstado', function() {
        let button = $(this);
        let roleId = button.data('id');
        let newEstado = button.data('estado') == 1 ? 0 : 1;
        let accion = newEstado == 1 ? 'activar' : 'desactivar';
        let mensaje = newEstado == 1 ? 'activado' : 'desactivado';
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas ${accion} este rol?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('roles.toggleEstado') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: roleId,
                        estado: newEstado
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                '¡Listo!',
                                `El rol ha sido ${mensaje} correctamente.`,
                                'success'
                            );
                            table.ajax.reload(); // Recarga la tabla automáticamente
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
