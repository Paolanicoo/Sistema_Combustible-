@extends('Layouts.app')

@section('titulo','Registro Combustible')

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
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
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

    
    /* Estilos para los botones */
    .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
        border-radius: 8px;
        padding: 0.5rem 1rem;
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
</style>

<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">
                <b>Registro de combustible</b>
            </h2>
            @if(Auth::user()->role !== 'Visualizador')
                <a href="{{ route('registrocombustible.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="combustible-table">
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
                            <th>Observación</th> <!-- Nueva columna Observación -->
                            <th class="acciones-columna text-center">Acciones</th> <!-- Centrado y ancho ajustado -->
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
        $('#combustible-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('registrocombustible.getTableData') }}',
            columns: [
                {data: 'fecha', name: 'fecha'},
                {data: 'vehiculo_equipo', name: 'vehiculo_equipo'},
                {data: 'vehiculo_marca', name: 'vehiculo_marca'},
                {data: 'vehiculo_placa', name: 'vehiculo_placa'},
                {data: 'vehiculo_asignado', name: 'vehiculo_asignado'},
                {data: 'num_factura', name: 'num_factura'},
                {data: 'entradas', name: 'entradas'},
                {data: 'salidas', name: 'salidas'},
                {data: 'observacion', name: 'observacion'}, <!-- Columna de Observación -->
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