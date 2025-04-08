@extends('Layouts.app')

@section('titulo', 'Inventario de Combustible')

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
    
    /* Mejora de los estilos del filtro de búsqueda */
    .dataTables_filter {
        margin-bottom: 20px;
        position: relative;
    }
    
    .dataTables_filter label {
        width: 100%;
        display: flex;
        align-items: center;
    }
    
    .dataTables_filter .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 1;
    }
    
    .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        width: 250px;
        transition: all 0.3s ease;
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
    
    .card-header {
        background-color: rgb(226, 228, 230);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
    
    .card-title {
        color: #344767;
        font-weight: 600;
    }
    
    /* Estilos para los botones */
    .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        border-radius: 12px;
        padding: 2rem 3rem;
        font-weight: 500;
        transition: all 0.3s ease;
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
    
    /* Reducir ancho de la columna "Acciones" */
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
    
    /* Botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }
    
    /* Mejora de Paginación - aplicado tanto a la paginación superior como inferior */
    .dataTables_paginate {
        padding-top: 15px !important;
        margin-top: 10px !important;
    }
    
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 3px !important;
        padding: 5px 12px !important;
        border: 1px solid #e2e8f0 !important;
        transition: all 0.2s ease !important;
    }
    
    .dataTables_paginate .paginate_button.current {
        background: #0ea5e9 !important;
        border-color: #0ea5e9 !important;
        color: white !important;
        font-weight: 500 !important;
    }
    
    .dataTables_paginate .paginate_button:hover {
        background: #e2e8f0 !important;
        border-color: #e2e8f0 !important;
        color: #334155 !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Estilo específico para los botones "Anterior" y "Siguiente" */
    .dataTables_paginate .paginate_button.previous, 
    .dataTables_paginate .paginate_button.next {
        border: none !important; /* Quitar bordes */
    }
    
    .dataTables_info {
        color: #64748b;
        padding-top: 1rem;
        font-size: 0.875rem;
    }

    .btn-nuevo-registro {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        font-weight: 2300;
        transition: all 0.3s ease;
        padding: 0.75rem 1rem; /* Aumento del tamaño del botón */
        font-size: 0.80rem; /* Aumento del tamaño del texto */
        border-radius: 8px; /* Bordes suaves */
        min-width: 20px; /* Aumento del ancho mínimo */
        text-align: center; /* Asegura que el texto esté centrado */
    }
    
    .btn-nuevo-registro:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b>Inventario de combustible</b>
            </h2>
            <a href="{{ route('combus.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                <i class="fas fa-plus"></i> Nuevo registro
            </a>            
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive mt-3">
                <table id="combustible-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Cantidad Entrada</th>
                            <th class="text-center">Cantidad Actual</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div> 
    </div> 
</div> 
<!-- Inicializar DataTable -->
<script>
    $(document).ready(function() {
        $('#combustible-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('combus.data') }}",
            columns: [
                { data: 'cantidad_entrada', name: 'cantidad_entrada' },
                { data: 'cantidad_actual', name: 'cantidad_actual' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            language: {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 100]],
        });
    });
</script>

<script>
   $(document).on('click', '.delete-btn', function () {
        var registroId = $(this).data('id');
        var deleteUrl = $(this).data('url');  // Obtener la URL de data-url
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Este registro será eliminado permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl, 
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado!', response.message, 'success');
                            $('#combustible-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error en AJAX:", xhr.responseText);
                        Swal.fire('Error!', 'Hubo un problema al eliminar el registro.', 'error');
                    }
                });
            }
        });
    });
</script>

@endsection
@section('scripts')
@endsection