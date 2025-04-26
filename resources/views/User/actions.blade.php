<div class="d-flex gap-2">
    @if(Auth::user()->role !== 'Visualizador')
        @if(!$usuario->is_protected)
            <!-- Botón de edición -->
            <a href="{{ route('user.edit', $usuario->id) }}" class="btn btn-warning btn-sm" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $usuario->id }}" title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        @else
            <!-- Indicador de usuario protegido -->
            <span class="badge bg-info fs-7">
                <i class="fas fa-shield-alt"></i> Protegido
            </span>
        @endif
    @endif
</div>
<!-- Importar SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on('click', '.delete-btn', function () {
        var usuarioId = $(this).data('id'); // Obtiene el ID del registro

        // Muestra la alerta de confirmación con SweetAlert
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Este registro será eliminado permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirma, realiza la petición AJAX
                $.ajax({
                    url: '{{ route("user.destroy", ":id") }}'.replace(':id', usuarioId),  // Usar la ruta con el ID del registro
                    type: 'DELETE',  // Método DELETE
                    data: {
                        _token: '{{ csrf_token() }}',  // Token CSRF
                    },
                    success: function(response) {
                        if (response.success) {
                            // Muestra mensaje de éxito
                            Swal.fire('Eliminado!', response.message, 'success');

                            // Elimina la fila correspondiente de la tabla de inmediato
                            $('#registro-' + usuarioId).remove();  // Elimina la fila con el ID 'registro-{id}'

                            // Recargar la página para reflejar los cambios
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Esperar 1 segundo antes de recargar la página

                        } else {
                            // Si hubo un error
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        Swal.fire('Error!', 'Hubo un problema al eliminar el registro.', 'error');
                    }
                });
            }
        });
    });
</script>