@extends('Layouts.app')

@section('titulo','Registro Combustible')

@section('contenido')

<!DOCTYPE html>
<html>
    <head>
        <title>Registro de Combustible - Datatables</title>
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
            <h3 class="card-title mb-0"><b>Registro de Combustible</b></h3>
            @if(Auth::user()->role !== 'visualizador')
                <a href="{{ route('registrocombustible.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i> Nuevo registro
                </a>
            @endif
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped w-100" id="combustible-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Asignado</th>
                    <th>N° de Factura</th>
                    <th>Entrada Galones</th>
                    <th>Salida Galones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
<<<<<<< HEAD
=======
                @forelse($registrocombustible as $registro)
                <tr>
                    <td>{{ $registro->fecha }}</td>    
                    <td>{{ $registro->vehiculo->equipo ?? 'N/A' }}</td>
                    <td>{{ $registro->vehiculo->marca ?? 'N/A' }}</td>
                    <td>{{ $registro->vehiculo->placa ?? 'N/A' }}</td>
                    <td>{{ $registro->vehiculo->asignado ?? 'N/A' }}</td>
                    <td>{{ $registro->num_factura }}</td>
                    <td>{{ $registro->entradas }}</td>
                    <td>{{ $registro->salidas }}</td>
                    <td>
                    @if(Auth::user()->role !== 'visualizador')
                    <div class="d-flex gap-2">
                            <a href="{{ route('registrocombustible.edit', $registro->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <form action="{{ route('registrocombustible.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> 
                                </button>
                             </form>
                            
                        
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">No hay registros de combustible</td>
                </tr>
                @endforelse
>>>>>>> dc531c7 (cambios)
            </tbody>
        </table>
    </div>
    </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#combustible-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('registrocombustible.getTableData') }}',
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'fecha', name: 'fecha'},
                        {data: 'vehiculo_equipo', name: 'vehiculo_equipo'},
                        {data: 'vehiculo_marca', name: 'vehiculo_marca'},
                        {data: 'vehiculo_placa', name: 'vehiculo_placa'},
                        {data: 'vehiculo_asignado', name: 'vehiculo_asignado'},
                        {data: 'num_factura', name: 'num_factura'},
                        {data: 'entradas', name: 'entradas'},
                        {data: 'salidas', name: 'salidas'},
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
