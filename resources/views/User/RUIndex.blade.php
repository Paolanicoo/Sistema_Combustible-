@extends('Layouts.app')

@section('titulo', 'User')

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

    .btn-nuevo-registro {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.80rem;
        border-radius: 8px;
        min-width: 160px;
        text-align: center;
    }

    .btn-nuevo-registro:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
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
        color: white;
    }

    /* Estilos para el botón de "eliminar" */
    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
    }
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b>Registro de usuarios</b>
            </h2>
           
            @if(Auth::user()->role !== 'Visualizador')
                <a href="{{ route('user.create') }}" class="btn btn-info btn-sm btn-nuevo-registro">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="users-table">
                    <thead>
                        <tr>
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
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('user.table') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'role', name: 'role'},
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
                }
            }
        });
    });
</script>
@endsection