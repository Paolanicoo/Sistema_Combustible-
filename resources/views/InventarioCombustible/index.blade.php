@extends('Layouts.app')

@section('titulo', 'Inventario de Combustible')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0"><i class="fas fa-gas-pump"></i> Inventario de Combustible</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('combus.create') }}" class="btn btn-light">
                        <i class="fas fa-plus-circle"></i> Nuevo Registro
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Entrada de Combustible</th>
                            <th>Cantidad Actual</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($combustibles as $combustible)
                        <tr>
                            <td>{{ $combustible->id }}</td>
                            <td>{{ $combustible->cantidad_entrada }} galones</td>
                            <td>{{ $combustible->cantidad_actual }} galones</td>
                            <td>{{ $combustible->descripcion }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('combus.edit', $combustible->id) }}" 
                                       class="btn btn-sm btn-warning"
                                       title="Registrar salida">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('combus.show', $combustible->id) }}" 
                                       class="btn btn-sm btn-info"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('combus.destroy', $combustible->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Eliminar registro">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($combustibles->isEmpty())
                <div class="alert alert-warning text-center">
                    No hay registros de combustible disponibles
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[0, 'desc']]
        });

        // Evento delegado para los formularios de eliminación
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const row = $(this).closest('tr');
            
            Swal.fire({
                title: '¿Eliminar registro?',
                html: `
                    <div class="text-left">
                        <p>Estás a punto de eliminar permanentemente:</p>
                        <ul>
                            <li>Entrada inicial: <strong>${row.find('td:nth-child(2)').text()}</strong></li>
                            <li>Cantidad actual: <strong>${row.find('td:nth-child(3)').text()}</strong></li>
                            <li>Descripción: <strong>${row.find('td:nth-child(4)').text()}</strong></li>
                        </ul>
                        <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> ¡Esta acción no se puede deshacer!</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    htmlContainer: 'text-left'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar carga mientras se procesa
                    Swal.fire({
                        title: 'Eliminando...',
                        html: 'Por favor espere',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar formulario
                    form.submit();
                }
            });
        });
    });

    // Mostrar mensaje de éxito si existe
    @if(session('deleted'))
        Swal.fire({
            icon: 'success',
            title: '¡Eliminado!',
            text: '{{ session('deleted') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection