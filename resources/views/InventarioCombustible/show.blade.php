@extends('Layouts.app')

@section('contenido')
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <!-- Botón para volver al inventario -->
        <a href="{{ route('combus.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al Inventario
        </a>
    </div>

    <div class="card shadow-lg p-4">
        <div class="card-header bg-primary text-white">
            <h3>Combustible disponible: {{ $combustible->cantidad }} galones</h3>
            <p>Fecha de registro: {{ $combustible->created_at->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="card-body">
            <h4>Historial de salidas</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad retirada</th>
                        <th>Saldo restante</th>
                        <th>Persona</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($combustible->historial as $h)
                    <tr>
                        <td>{{ $h->fecha }}</td>
                        <td>{{ $h->cantidad_retirada }}</td>
                        <td>{{ $h->cantidad_restante }}</td>
                        <td>{{ $h->persona }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilo personalizado para la tarjeta */
    .card {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-secondary {
        font-size: 1rem;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        background-color: transparent;
        color: #4CAF50;
        border: 2px solid #4CAF50;
    }

    .btn-outline-secondary:hover {
        background-color: #4CAF50;
        color: white;
    }
</style>
@endsection
