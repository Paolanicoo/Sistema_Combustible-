@extends('Layouts.app')

@section('titulo', 'Resumen de Importes')

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
        width: 100%;
        margin: 0 auto;
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
    .btn-info, .btn-nuevo-registro {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-info:hover, .btn-nuevo-registro:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
        color: white;
    }
    
    /* Estilos para la tabla */
    .table {
        width: 100% !important;
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
        white-space: nowrap;
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

