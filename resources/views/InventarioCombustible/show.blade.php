@extends('Layouts.app')

@section('titulo', 'Detalles de Combustible')

@section('contenido')

@include('sweetalert::alert')
<style>
    /* Estilos modernos y profesionales alineados con el diseño principal */
    .card-detail {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    /* Encabezado de la tarjeta con fondo gris claro y borde inferior */
    .card-header-detail {
        background-color: rgb(226, 228, 230);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        color: #344767;
    }
    /* Cuerpo de la tarjeta con padding para separación */
    .card-body-detail {
        padding: 1.5rem;
    }
    /* Badge informativo azul con texto blanco y bordes redondeados */
    .info-badge {
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background-color: #0ea5e9;
        color: white;
    }
     /* Tabla personalizada para ajustar espaciados y estilos */
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
     /* Estilos para encabezados de tabla: color, fuente y fondo */
    .table-custom thead th {
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    /* Transición suave para filas en tbody */
    .table-custom tbody tr {
        transition: all 0.2s;
    }
    /* Cambio de color de fondo al pasar el mouse sobre filas */
    .table-custom tbody tr:hover {
        background-color: #f1f5f9;
    }
      /* Celdas del tbody con padding, alineación vertical y color de texto */
    .table-custom tbody td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        color: #334155;
    }
     /* Botón "Atrás" con estilo transparente y borde azul */
    .btn-back {
        background-color: transparent;
        border-color: #0ea5e9;
        color: #0ea5e9;
        font-weight: 500;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
     /* Efecto hover del botón "Atrás": fondo azul y texto blanco */
    .btn-back:hover {
        background-color: #0ea5e9;
        color: white;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
    }
    /* Tarjeta de estado con borde lateral azul y fondo gris claro */
    .status-card {
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: #f8f9fa;
        border-left: 4px solid #0ea5e9;
    }
     /* Contenedor para barra de progreso con fondo gris y bordes redondeados */
    .progress-container {
        height: 8px;
        background: #e9ecef;
        border-radius: 5px;
        margin: 1rem 0;
    }
     /* Barra de progreso personalizada con fondo azul y bordes redondeados */
    .progress-bar-custom {
        height: 100%;
        border-radius: 5px;
        background: #0ea5e9;
    }
    /* Estilo base para badges con padding y bordes redondeados */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 6px;
    }
    /* Badge rojo para estados de peligro o alertas */
    .bg-danger {
        background-color: #ef4444 !important;
        color: white;
    }
    /* Badge verde para estados de éxito o confirmación */
    .bg-success {
        background-color: #10b981 !important;
        color: white;
    }
    /* Badge azul para información */
    .bg-info {
        background-color: #0ea5e9 !important;
        color: white;
    }
</style>

<div class="container mt-5">
    <!-- Tarjeta principal -->
    <div class="card card-detail mb-4">
        <div class="card-header card-header-detail">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center">
                        <!-- Botón para volver a la lista de combustibles -->
                        <a href="{{ route('combus.index') }}" class="btn btn-back me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <!-- Título de la página -->
                        <h2 class="mb-1"> Detalles de Combustible</h2>
                    </div>
                    <!-- Fecha de registro formateada -->
                    <p class="mb-0 mt-2"><i class="far fa-calendar-alt me-2"></i> Registrado el: {{ $combustible->created_at->format('d/m/Y') }}</p>
                </div>
                <!-- Badge que muestra la cantidad actual de galones disponibles -->
                <span class="info-badge">
                    <i class="fas fa-tint me-1"></i> {{ $combustible->cantidad_actual }} galones
                </span>
            </div>
        </div>

        <div class="card-body card-body-detail">
            <!-- Tarjeta de estado -->
            <div class="status-card">
                <div class="row">
                    <div class="col-md-4">
                         <!-- Entrada inicial de combustible -->
                        <h5><i class="fas fa-box-open text-primary me-2"></i> Entrada Inicial</h5>
                        <h3 class="text-primary">{{ $combustible->cantidad_entrada }} galones</h3>
                    </div>
                    <div class="col-md-4">
                         <!-- Porcentaje disponible calculado en PHP -->
                        <h5><i class="fas fa-percentage text-info me-2"></i> Porcentaje Disponible</h5>
                        @php
                            $porcentaje = ($combustible->cantidad_actual / $combustible->cantidad_entrada) * 100;
                        @endphp
                        <h3 class="text-info">{{ number_format($porcentaje, 2) }}%</h3>
                    </div>
                    <div class="col-md-4">
                        <!-- Número total de movimientos en el historial -->
                        <h5><i class="fas fa-exchange-alt text-success me-2"></i> Movimientos</h5>
                        <h3 class="text-success">{{ $combustible->historial->count() }}</h3>
                    </div>
                </div>
                 <!-- Barra de progreso visual que refleja el porcentaje disponible -->
                <div class="progress-container">
                    <div class="progress-bar-custom" style="width: {{ $porcentaje }}%"></div>
                </div>
            </div>

            <!-- Historial de salidas -->
            <h4 class="mb-3"><i class="fas fa-history text-secondary me-2"></i> Historial de Salidas</h4>
            
            @if($combustible->historial->isEmpty())
             <!-- Mensaje cuando no hay registros de salida -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No hay registros de salida para este combustible.
                </div>
            @else
            <!-- Tabla responsiva que muestra el historial de salidas -->
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th><i class="far fa-calendar me-1"></i> Fecha</th>
                                <th><i class="fas fa-minus-circle me-1"></i> Retirado</th>
                                <th><i class="fas fa-tint me-1"></i> Saldo Restante</th>
                                <th><i class="fas fa-user me-1"></i> Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($combustible->historial as $h)
                            <tr>
                                <!-- Fecha y hora formateadas -->
                                <td>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y H:i') }}</td>
                                 <!-- Cantidad retirada con badge rojo -->
                                <td><span class="badge bg-danger">{{ $h->cantidad_retirada }} galones</span></td>
                                 <!-- Cantidad restante con badge verde -->
                                <td><span class="badge bg-success">{{ $h->cantidad_restante }} galones</span></td>
                                <!-- Nombre del responsable -->
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