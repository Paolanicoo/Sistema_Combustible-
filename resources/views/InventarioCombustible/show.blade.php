@extends('Layouts.app')

@section('titulo', 'Detalles de Combustible')

@section('contenido')
<style>
    /* Estilos modernos y profesionales */
    .card-detail {
        border-radius: 12px;
        border: none;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card-detail:hover {
        transform: translateY(-5px);
    }

    .card-header-detail {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }

    .card-body-detail {
        padding: 2rem;
    }

    .info-badge {
        font-size: 1.1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }

    .table-custom {
        border-radius: 10px;
        overflow: hidden;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        transition: all 0.2s;
    }

    .table-custom tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .btn-back {
        border-radius: 30px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
        border: 2px solid #3a7bd5;
        color: #3a7bd5;
        background: transparent;
    }

    .btn-back:hover {
        background: #3a7bd5;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(58, 123, 213, 0.2);
    }

    .status-card {
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: #f8f9fa;
        border-left: 4px solid #3a7bd5;
    }

    .progress-container {
        height: 10px;
        background: #e9ecef;
        border-radius: 5px;
        margin: 1rem 0;
    }

    .progress-bar-custom {
        height: 100%;
        border-radius: 5px;
        background: linear-gradient(90deg, #3a7bd5 0%, #00d2ff 100%);
    }
</style>

<div class="container py-4">
    <!-- Botón de regreso -->
    <div class="mb-4">
        <a href="{{ route('combus.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left mr-2"></i> Volver al Inventario
        </a>
    </div>

    <!-- Tarjeta principal -->
    <div class="card card-detail mb-4">
        <div class="card-header card-header-detail">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-gas-pump mr-2"></i> Detalles de Combustible</h2>
                    <p class="mb-0"><i class="far fa-calendar-alt mr-2"></i> Registrado el: {{ $combustible->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="info-badge bg-white text-primary">
                    <i class="fas fa-tint mr-1"></i> {{ $combustible->cantidad_actual }} galones
                </span>
            </div>
        </div>

        <div class="card-body card-body-detail">
            <!-- Tarjeta de estado -->
            <div class="status-card">
                <div class="row">
                    <div class="col-md-4">
                        <h5><i class="fas fa-box-open text-primary mr-2"></i> Entrada Inicial</h5>
                        <h3 class="text-primary">{{ $combustible->cantidad_entrada }} galones</h3>
                    </div>
                    <div class="col-md-4">
                        <h5><i class="fas fa-percentage text-info mr-2"></i> Porcentaje Disponible</h5>
                        @php
                            $porcentaje = ($combustible->cantidad_actual / $combustible->cantidad_entrada) * 100;
                        @endphp
                        <h3 class="text-info">{{ number_format($porcentaje, 2) }}%</h3>
                    </div>
                    <div class="col-md-4">
                        <h5><i class="fas fa-exchange-alt text-success mr-2"></i> Movimientos</h5>
                        <h3 class="text-success">{{ $combustible->historial->count() }}</h3>
                    </div>
                </div>
                <div class="progress-container">
                    <div class="progress-bar-custom" style="width: {{ $porcentaje }}%"></div>
                </div>
            </div>

            <!-- Historial de salidas -->
            <h4 class="mb-3"><i class="fas fa-history text-secondary mr-2"></i> Historial de Salidas</h4>
            
            @if($combustible->historial->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> No hay registros de salida para este combustible.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th><i class="far fa-calendar mr-1"></i> Fecha</th>
                                <th><i class="fas fa-minus-circle mr-1"></i> Retirado</th>
                                <th><i class="fas fa-tint mr-1"></i> Saldo Restante</th>
                                <th><i class="fas fa-user mr-1"></i> Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($combustible->historial as $h)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y H:i') }}</td>
                                <td><span class="badge bg-danger">{{ $h->cantidad_retirada }} galones</span></td>
                                <td><span class="badge bg-success">{{ $h->cantidad_restante }} galones</span></td>
                                <td>{{ $h->persona }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Efecto hover mejorado para filas de tabla
    document.querySelectorAll('.table-custom tbody tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.boxShadow = 'none';
        });
    });
</script>

@endsection