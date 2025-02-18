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
                    <th>Consumo</th>  
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
                <td>{{ $registro->combustible ? $registro->combustible->num_factura: 'N/A'}}</td>
                <<td>{{ $registro->combustible->entradas > 0 ? $registro->combustible->entradas : $registro->combustible->salidas ?? 'N/A' }}</td>
                <td>{{$registro->combustible->precio  ?? 'N/A'}}</td>
                <td>{{ $registro->total }}</td>
                <td>{{$registro->empresa}}</td>
                <td>{{$registro->cog}}</td>
                <td>
                        <div class="action-buttons">
                        <a href="{{ route('registroimporte.edit', $registro->id) }}" class="btn btn-warning">Editar</a>

                        <form action="{{ route('registroimporte.destroy', $registro->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                    </form>
                        </div>
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