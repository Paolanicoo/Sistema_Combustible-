@extends('Layouts.LayoutPrincipal')

@section('titulo','index')

@section('contenido')

    <div class="container mt-5">
        <h2 class="mb-4">Registro Vehicular</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
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
                @forelse($registrovehiculars as $registrovehicular)
                <tr>
                <td>{{$registrovehicular->equipo}}</td>
                <td>{{$registrovehicular->marca}}</td>
                <td>{{$registrovehicular->placa}}</td>
                <td>{{$registrovehicular->modelo}}</td>
                <td>{{$registrovehicular->motor}}</td>
                <td>{{$registrovehicular->serie}}</td>
                <td>{{$registrovehicular->asignado}}</td>
                <td>{{$registrovehicular->observacion}}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="9">No hay Vehiculos</td>
                </tr>
                @endforelse

            </tbody>
        </table>
        <a href="{{route('registrovehicular.create')}}" class="btn btn-success">Agregar Nuevo</a>
    </div>


{{ $registrovehiculars->render('pagination::bootstrap-4') }}

@endsection()