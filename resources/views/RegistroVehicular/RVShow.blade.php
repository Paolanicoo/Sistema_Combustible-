@extends('Layouts.app')

@section('titulo', 'Detalles del Vehículo')

@section('contenido')
    <!-- Mostrar los detalles del vehículo -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><b>Detalles del Vehículo</b></h3>
            </div>
            <div class="card-body">
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
                        <p><strong>Observación:</strong> {{ $registro->observacion }}</p>
                        <p><strong>Asignado a:</strong> {{ $registro->asignado }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Asignaciones -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h4>Historial de Asignaciones</h4>
            </div>
            <div class="card-body">
                <table id="historial-asignaciones-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Asignado a</th>
                            <th>Fecha de Asignación</th>
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

        <!-- Botón de regreso -->
        <div class="text-center mt-3">
            <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary">Volver a la lista</a>
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
