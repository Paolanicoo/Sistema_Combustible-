@extends('Layouts.LayoutPrincipal')

@section('titulo','index')

@section('contenido')

    <div class="container mt-5">
        <h2 class="mb-4">Resumen Importe</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                <th>Mes</th>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Asignado</th>
                    <th>N de factura</th>
                    <th>Consumo</th>  <!-- Cambia 'Salida' por 'Consumo' -->
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Empresa</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registroimporte as $registro)
                <tr>
                <td>{{ \Carbon\Carbon::parse($registroimporte->first()->fecha)->translatedFormat('F') }}</td>
                <td>{{ $registro->combustible->fecha ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->equipo ?? 'N/A' }}</td>
                 <td>{{ $registro->vehiculo->marca ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->placa ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->asignado ?? 'N/A' }}</td>
                <td>{{ $registro->combustible->num_factura }}</td>
                <td>{{ $registro->combustible->salidas ?? 'N/A' }}</td> <!-- Consumo -->
                <td>{{$registro->combustible->precio  ?? 'N/A'}}</td>
                <td>{{ $registro->total }}</td>
                <td>{{$registro->empresa}}</td>
                <td>{{$registro->cog}}</td>
                
                    <td>
                    <a href="{{ route('registroimporte.edit', $registro->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="13">No hay importes</td>
                </tr>
                
                @endforelse

            </tbody>
        </table>
        <a href="{{route('registroimporte.create')}}" class="btn btn-success">Agregar Nuevo</a>
    </div>


{{ $registroimporte->render('pagination::bootstrap-4') }}

@endsection()