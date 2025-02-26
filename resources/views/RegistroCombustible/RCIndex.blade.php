@extends('Layouts.app')

@section('titulo','index')

@section('contenido')

<style>
    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .fixed-table th:nth-child(9), .fixed-table td:nth-child(9) {
        width: 100px; /* Cambié el ancho de la columna 'Acciones' */
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        gap: 1px;
    }

    button {
        white-space: nowrap;
        padding: 8px 10px;
        font-size: 8px;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .fixed-table {
        width: 100%;
        table-layout: auto; /* Usamos auto para que el contenido ajuste el tamaño de la columna */
    }

    .fixed-table th, .fixed-table td {
        word-wrap: break-word; /* Permite que el texto se divida en varias líneas si es largo */
        overflow: hidden;      /* Oculta cualquier contenido que se desborde */
        white-space: nowrap;   /* Evita que el texto se divida y fuerza que todo esté en una línea */
        text-overflow: ellipsis; /* Muestra "..." si el contenido es demasiado largo */
    }

    td {
        vertical-align: middle;
    }

    /* Anchos específicos para las columnas */
    .fixed-table th:nth-child(1), .fixed-table td:nth-child(1) {
        width: 120px;
    }

    .fixed-table th:nth-child(2), .fixed-table td:nth-child(2) {
        width: 150px;
    }

    .fixed-table th:nth-child(3), .fixed-table td:nth-child(3) {
        width: 150px;
    }

    .fixed-table th:nth-child(4), .fixed-table td:nth-child(4) {
        width: 120px;
    }

    .fixed-table th:nth-child(5), .fixed-table td:nth-child(5) {
        width: 120px;
    }

    .fixed-table th:nth-child(6), .fixed-table td:nth-child(6) {
        width: 130px;
    }

    .fixed-table th:nth-child(7), .fixed-table td:nth-child(7) {
        width: 150px;
    }

    .fixed-table th:nth-child(8), .fixed-table td:nth-child(8) {
        width: 150px;
    }

    .fixed-table th:nth-child(5), .fixed-table td:nth-child(5),
    .fixed-table th:nth-child(6), .fixed-table td:nth-child(6) {
        width: 140px; /* Puedes ajustar el ancho de las columnas que tienen valores más largos como 'Factura' */
    }
</style>


<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><b>Registro combustible</b></h2>
        <!-- Solo mostrar el botón si el usuario NO es visualizador -->
        @if(Auth::user()->role !== 'visualizador')
        <a href="{{ route('registrocombustible.create') }}" class="btn btn-success">Agregar nuevo</a>
        @endif
    </div>
    <div class="table-container">
        <table class="table table-striped table-bordered fixed-table">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Asignado</th>
                    <th>N° de factura</th>
                    <th>Entrada galones</th>
                    <th>Salidas galones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
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
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('registrocombustible.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Eliminar
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
            </tbody>
        </table>
    </div>
</div>


{{ $registrocombustible->render('pagination::bootstrap-4') }}

@endsection()