@extends('Layouts.app')

@section('titulo', 'Editar Rol')

@section('contenido')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Editar Estado de Rol</h3>
        </div>
        <div class="card-body text-center">
            <h4>{{ $role->rol }}</h4>

            <button id="toggleEstado"
                class="btn {{ $role->estado ? 'btn-success' : 'btn-danger' }} toggleEstado"
                data-id="{{ $role->id }}" data-estado="{{ $role->estado }}">
                {{ $role->estado ? 'Activo' : 'Inactivo' }}
            </button>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggleEstado').click(function() {
            let button = $(this);
            let roleId = button.data('id');
            let newEstado = button.data('estado') == 1 ? 0 : 1;

            $.ajax({
                url: "{{ route('roles.toggleEstado') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: roleId,
                    estado: newEstado
                },
                success: function(response) {
                    if (response.success) {
                        button.data('estado', newEstado);
                        button.text(newEstado ? 'Activo' : 'Inactivo');
                        button.toggleClass('btn-success btn-danger');
                    }
                }
            });
        });
    });
</script>
@endsection
