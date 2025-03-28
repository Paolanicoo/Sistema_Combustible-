@extends('Layouts.app')

@section('titulo', 'Inventario de Combustible')

@section('contenido')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
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
                            <th>Descripción</th>
                            <th>Cantidad Actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($combustibles as $combustible)
                        <tr>
                            <td>{{ $combustible->id }}</td>
                            <td>{{ $combustible->descripcion }}</td>
                            <td>{{ $combustible->cantidad }} galones</td>
                            <td>
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
                                 <!-- Botón Eliminar -->
        <form action="{{ route('combus.destroy', $combustible->id) }}" method="POST" class="d-inline delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar registro">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
                                
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

<script>
    $(document).ready(function() {
        $('table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[0, 'desc']]
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmación para eliminar
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Confirmar eliminación?',
                text: "¡El combustible y su historial serán eliminados permanentemente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection