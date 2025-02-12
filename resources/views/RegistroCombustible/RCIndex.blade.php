@extends('Layouts.LayoutPrincipal')

@section('titulo','index')

@section('contenido')

    <div class="container mt-5">
        <h2 class="mb-4">Registro Combustible</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Asignado</th>
                    <th>N de factura</th>
                    <th>Entrada galones</th>
                    <th>Salidas galones</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($registrocombustibles as $registrocombustible)
                <tr>
                <td>{{$registrocombustible->fecha}}</td>    
                <td>{{$registrocombustible->equipo}}</td>
                <td>{{$registrocombustible->marca}}</td>
                <td>{{$registrocombustible->placa}}</td>
                <td>{{$registrocombustible->asignado}}</td>
                <td>{{$registrocombustible->numfac}}</td>
                <td>{{$registrocombustible->engalones}}</td>
                <td>{{$registrocombustible->sagalones}}</td>
                
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="9">No hay Consumos</td>
                </tr>
                @endforelse

            </tbody>
        </table>
        <a href="{{route('registrocombustible.create')}}" class="btn btn-success">Agregar Nuevo</a>
    </div>


{{ $registrocombustibles->render('pagination::bootstrap-4') }}

@endsection()