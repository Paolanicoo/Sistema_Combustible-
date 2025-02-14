@extends('Layouts.LayoutPrincipal')

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
        width: 160px;
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
        table-layout: fixed;
    }

    .fixed-table th, .fixed-table td {
        word-wrap: break-word;
        overflow: hidden;
    }

    td {
        vertical-align: middle;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><b>Registro Combustible</b></h2>
        <a href="{{ route('registrocombustible.create') }}" class="btn btn-success">Agregar nuevo</a>
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
                    <th>N° de Factura</th>
                    <th>Entrada Galones</th>
                    <th>Salidas Galones</th>
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
                        <div class="action-buttons">
                            <a href="" class="btn btn-primary btn-sm">Editar</a>
                            <form action="" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                            </form>
                        </div>
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