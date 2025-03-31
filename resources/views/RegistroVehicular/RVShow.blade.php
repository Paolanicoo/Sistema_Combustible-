@extends('Layouts.app')

@section('titulo', 'Detalles del Vehículo')

@section('contenido')
    <!-- Mostrar los detalles del vehículo -->
    <div class="container mt-5">        
        <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #e8f4fd; color: #333;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-car me-2"></i><b>Detalles del vehículo</b>
                </h3>
                <a href="javascript:window.history.back();" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Equipo:</strong> {{ $registro->equipo }}</p>
                        <p><strong>Marca:</strong> {{ $registro->marca }}</p>
                        <p><strong>Placa:</strong> {{ $registro->placa }}</p>
                        <p><strong>Modelo:</strong> {{ $registro->modelo }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Motor:</strong> {{ $registro->motor }}</p>
                        <p><strong>Serie:</strong> {{ $registro->serie }}</p>
                        <p><strong>Asignado:</strong> {{ $registro->asignado }}</p>
                        <p><strong>Observación:</strong> {{ $registro->observacion }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Asignaciones -->
        <div class="card shadow mt-4">
            <div class="card-header" style="background-color: #e8f4fd; color: #333;">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historial de asignaciones</h4>
            </div>
            <div class="card-body">
                <table id="historial-asignaciones-table" class="table table-striped table-hover">
                    <thead>
                        <tr style="background-color: #f8f9fa; color: #333;">
                            <th>Asignado</th>
                            <th>Fecha de asignación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historialAsignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->asignado }}</td>
                                <td>{{ $asignacion->fecha_asignacion }}</td>
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