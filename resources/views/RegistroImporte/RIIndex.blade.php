@extends('Layouts.app')

@section('titulo','index')

@section('contenido')

<div class="container mt-5">
    <h2 class="mb-4">Resumen importe</h2>
    @if(Auth::user()->role !== 'visualizador')

    <!-- Botón Agregar Nuevo -->
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('registroimporte.create') }}" class="btn btn-success">Agregar nuevo</a>
        @endif
    </div>

    <!-- Formulario de filtros -->
    <form action="{{ route('registroimporte.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="equipo">Equipo:</label>
                <input type="text" name="equipo" id="equipo" class="form-control" value="{{ request('equipo') }}">
            </div>

            <div class="col-md-3">
                <label for="asignado">Asignado:</label>
                <input type="text" name="asignado" id="asignado" class="form-control" value="{{ request('asignado') }}">
            </div>

            <div class="col-md-3">
                <label for="mes">Mes:</label>
                <select name="mes" id="mes" class="form-control">
                    <option value="">Todos</option>
                    @foreach(['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'] as $key => $value)
                        <option value="{{ $key + 1 }}" {{ request('mes') == $key + 1 ? 'selected' : '' }}>
                            {{ ucfirst($value) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-50">
                    <i class="fas fa-search"></i> 
                </button>
                <a href="{{ route('registroimporte.index') }}" class="btn btn-secondary w-50">
                    <i class="fas fa-eraser"></i> 
                </a>
            </div>
        </div>
    </form>
</div> <!-- Cierre del contenedor -->

        <!-- Tabla -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
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
                    <th>Acciones</th>
                </tr>
            </thead>
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
                    @if(Auth::user()->role !== 'visualizador')
                        <div class="d-flex gap-2">
                            <a href="{{ route('registroimporte.edit', $registro->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <form action="{{ route('registroimporte.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
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
                    <td colspan="13" class="text-center">No hay importes</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $registroimporte->render('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection
