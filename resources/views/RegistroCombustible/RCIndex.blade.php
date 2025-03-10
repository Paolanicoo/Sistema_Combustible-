@extends('Layouts.app')

@section('titulo','Registro Combustible')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<!DOCTYPE html>
<html>
    <head>
        <title>Registro de Combustible - Datatables</title>
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <!-- Para el paquete de SweetAlert configurado -->
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <style>
        /* Reducir ancho de la columna "Acciones" */
        .acciones-columna {
            width: 40px; /* Aumenté el tamaño para permitir más espacio para los botones */
            text-align: center;
        }

        /* Centrar los botones en la columna de acciones */
        .acciones-columna div {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="card p-4"> <!-- Aumenté el padding aquí para la separación -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><b>Registro de combustible</b></h3>
                    @if(Auth::user()->role !== 'Visualizador')
                        <a href="{{ route('registrocombustible.create') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus"></i> Nuevo registro
                        </a>
                    @endif
                </div>
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
                                <th class="acciones-columna text-center">Acciones</th> <!-- Centrado y ancho ajustado -->
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
    </body>
</html>
@endsection