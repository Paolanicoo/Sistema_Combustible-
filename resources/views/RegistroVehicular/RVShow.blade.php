@extends('Layouts.app')

@section('titulo', 'Detalles del Vehículo')

@section('contenido')

<style>
    .btn-secondary {
        background-color: #f1f5f9;
        color: #000; /* Cambiado a negro */
        border: none;
    }
    
    .btn-secondary:hover {
        background-color: #e2e8f0;
    }

</style>

    <!-- Mostrar los detalles del vehículo -->
    <div class="container mt-5">        
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #e2e8f0; color: #344767;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-car me-2"></i><b>Detalles del vehículo</b>
                </h3>
                <a href="javascript:window.history.back();" class="btn btn-secondary btn-icon">
                    <i class="fas fa-arrow-left"></i> 
                </a>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <p style="color: #334155;"><strong>Equipo:</strong> {{ $registro->equipo }}</p>
                        <p style="color: #334155;"><strong>Marca:</strong> {{ $registro->marca }}</p>
                        <p style="color: #334155;"><strong>Placa:</strong> {{ $registro->placa }}</p>
                        <p style="color: #334155;"><strong>Modelo:</strong> {{ $registro->modelo }}</p>
                    </div>
                    <div class="col-md-6">
                        <p style="color: #334155;"><strong>Motor:</strong> {{ $registro->motor }}</p>
                        <p style="color: #334155;"><strong>Serie:</strong> {{ $registro->serie }}</p>
                        <p style="color: #334155;"><strong>Asignado:</strong> {{ $registro->asignado }}</p>
                        <p style="color: #334155;"><strong>Observación:</strong> {{ $registro->observacion }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Asignaciones -->
        <div class="card shadow mt-4">
            <div class="card-header" style="background-color: #e2e8f0; color: #344767;">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historial de asignaciones</h4>
            </div>
            <div class="card-body">
                <table id="historial-asignaciones-table" class="table table-striped table-hover">
                    <thead>
                        <tr style="background-color: #f8f9fa; color: #344767;">
                            <th style="color: #344767;">Asignado</th>
                            <th style="color: #344767;">Fecha de asignación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historialAsignaciones as $asignacion)
                            <tr>
                                <td style="color: #334155;">{{ $asignacion->asignado }}</td>
                                <td style="color: #334155;">{{ $asignacion->fecha_asignacion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Agregar DataTable script -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#historial-asignaciones-table').DataTable({
                processing: true,
                serverSide: true, 
                ajax: '{{ route('historialasignaciones.data', $registro->id) }}', 
                columns: [
                    { data: 'asignado', name: 'asignado' },
                    { data: 'fecha_asignacion', name: 'fecha_asignacion' },
                    { data: 'fecha_cambio', name: 'fecha_cambio' }
                ],
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endsection
