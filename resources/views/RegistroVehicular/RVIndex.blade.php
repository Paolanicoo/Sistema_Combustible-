@extends('Layouts.app')

@section('titulo', 'Gestión de Registros Vehiculares')

@section('contenido')

<!DOCTYPE html>
<html>
    <head>
        <title>Gestión de Registros Vehiculares - Datatables</title>
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
    <div class="container mt-5">
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><b>Registros vehiculares</b></h3>
                @if(Auth::user()->role !== 'visualizador')
                    <a href="{{ route('registrovehicular.create') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-plus"></i> Nuevo registro
                    </a>
                @endif   
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="vehiculos-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Motor</th>
                            <th>Serie</th>
                            <th>Asignado</th>
                            <th>Observación</th>
                            <th>Acciones</th>
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
            $('#vehiculos-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('registrovehicular.table') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'equipo', name: 'equipo'},
                    {data: 'marca', name: 'marca'},
                    {data: 'placa', name: 'placa'},
                    {data: 'modelo', name: 'modelo'},
                    {data: 'motor', name: 'motor'},
                    {data: 'serie', name: 'serie'},
                    {data: 'asignado', name: 'asignado'},
                    {data: 'observacion', name: 'observacion'},
                    {data: 'acciones', name: 'acciones', orderable: false, searchable: false} 
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
