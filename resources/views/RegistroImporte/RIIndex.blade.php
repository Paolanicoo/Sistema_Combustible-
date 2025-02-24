@extends('Layouts.app')

@section('titulo','index')

@section('contenido')

    <div class="container mt-5">
        <h2 class="mb-4">Resumen Importe</h2>
        <a href="{{route('registroimporte.create')}}" class="btn btn-success">Agregar Nuevo</a>
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
            <form action="{{ route('registroimporte.index') }}" method="GET" class="mb-4">
    <div class="row">
        <!-- Filtro por equipo -->
        <div class="col-md-3">
            <label for="equipo">Equipo:</label>
            <input type="text" name="equipo" id="equipo" class="form-control" value="{{ request('equipo') }}">
        </div>

        <!-- Filtro por asignado -->
        <div class="col-md-3">
            <label for="asignado">Asignado:</label>
            <input type="text" name="asignado" id="asignado" class="form-control" value="{{ request('asignado') }}">
        </div>

        <!-- Filtro por mes -->
        <div class="col-md-3">
            <label for="mes">Mes:</label>
            <select name="mes" id="mes" class="form-control">
                <option value="">Todos</option>
                @foreach(['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'] as $key => $value)
                    <option value="{{ $key + 1 }}" {{ request('mes') == $key + 1 ? 'selected' : '' }}>{{ ucfirst($value) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Botón de búsqueda -->
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('registroimporte.index') }}" class="btn btn-secondary ms-2">Limpiar</a>
        </div>
    </div>
</form>

            <tbody>
                @forelse($registroimporte as $registro)
                <tr>
                <td>{{ \Carbon\Carbon::parse($registro->fecha)->locale('es')->translatedFormat('F') }}</td>
                <td>{{ $registro->combustible->fecha ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->equipo ?? 'N/A' }}</td>
                 <td>{{ $registro->vehiculo->marca ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->placa ?? 'N/A' }}</td>
                <td>{{ $registro->vehiculo->asignado ?? 'N/A' }}</td>
                <td>{{ $registro->combustible ? $registro->combustible->num_factura: 'N/A'}}</td>
                <td>{{ $registro->combustible->entradas > 0 ? $registro->combustible->entradas : $registro->combustible->salidas ?? 'N/A' }}</td>
                <td>{{$registro->combustible->precio  ?? 'N/A'}}</td>
                <td>{{ ($registro->combustible->entradas > 0 ? $registro->combustible->entradas : $registro->combustible->salidas) * $registro->combustible->precio ?? 'N/A' }}</td>
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
        
    </div>


{{ $registroimporte->render('pagination::bootstrap-4') }}

@endsection()