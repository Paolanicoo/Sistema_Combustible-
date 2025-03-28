<!-- resources/views/RegistroVehicular/RVShow.blade.php -->

@extends('Layouts.app')

@section('titulo', 'Detalles del Vehículo')

@section('contenido')
    <!-- Mostrar los detalles del vehículo -->
    <div class="container mt-5">
        <div class="card p-4">
            <div class="card-header">
                <h3 class="card-title"><b>Detalles del Vehículo</b></h3>
            </div>
            <div class="card-body">
                <p><strong>Equipo:</strong> {{ $registro->equipo }}</p>
                <p><strong>Marca:</strong> {{ $registro->marca }}</p>
                <p><strong>Placa:</strong> {{ $registro->placa }}</p>
                <p><strong>Modelo:</strong> {{ $registro->modelo }}</p>
                <p><strong>Motor:</strong> {{ $registro->motor }}</p>
                <p><strong>Serie:</strong> {{ $registro->serie }}</p>
                <p><strong>Observación:</strong> {{ $registro->observacion }}</p>
                <p><strong>Asignado a:</strong> {{ $registro->asignado }}</p>

                <hr>

                <!-- Mostrar historial de asignaciones -->
                <h4>Historial de Asignaciones</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Asignado a</th>
                            <th>Fecha de Asignación</th>
                            <th>Fecha de Cambio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historialAsignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->asignado }}</td>
                                <td>{{ $asignacion->fecha_asignacion }}</td>
                                <td>{{ $asignacion->fecha_cambio ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary">Volver a la lista</a>
            </div>
        </div>
    </div>
    
@endsection
@section('scripts')
    <!-- Agregar DataTable script -->
    <script type="text/javascript">
        $(document).ready(function () {
            // Inicializar DataTable para el historial de asignaciones
            $('#historial-asignaciones-table').DataTable({
                processing: true,
                serverSide: true,  // Activar serverSide para cargar datos dinámicamente
                ajax: '{{ route('historialasignaciones.data', $registro->id) }}', // Ruta para cargar los datos
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
