@extends('Layouts.app')

@section('titulo', 'Resumen de Importes')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Para el paquete de SweetAlert configurado -->
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    /* Ajustar el tamaño del contenedor */
    .container {
        width: 100%; /* Ahora el contenedor usa el 100% del ancho */
        max-width: 100%; /* Se elimina el máximo ancho para que no se limite */
        margin: 0 auto;
    }

    /* Ajustar el ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px; /* Ajusta el tamaño según sea necesario */
        text-align: center;
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    /* Evitar el scroll horizontal */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    /* Asegurarse de que la tabla ocupe todo el espacio disponible */
    .table {
        width: 100% !important;
    }

    /* Ajustar las columnas */
    table.dataTable thead th {
        white-space: nowrap; /* Evita el ajuste de texto en las cabeceras */
    }
</style>

<div class="container mt-5">
    <div class="card p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><b>Resumen de Importes</b></h3>
            @if(Auth::user()->role !== 'Visualizador')
                <a href="{{ route('registroimporte.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i> Agregar nuevo
                </a>
            @endif
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped" id="importes-table">
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
                        <th>Total</th>
                        <th>Empresa</th>
                        <th>Tipo</th>
                        <th class="acciones-columna text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#importes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('registroimporte.table') }}',
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

