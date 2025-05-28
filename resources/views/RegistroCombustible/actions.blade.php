<div class="d-flex gap-2">
@if(Auth::user()->role !== 'Visualizador')
    <a href="{{ route('registrocombustible.edit', $registro->id) }}" class="btn btn-warning btn-sm" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $registro->id }}" title="Eliminar">
        <i class="fas fa-trash"></i>
    </button>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-btn', function () {
        var registroId = $(this).data('id'); // Obtiene el ID del registro
        console.log('ID del registro:', registroId);  // Depuración

        // Confirma la eliminación con SweetAlert
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Este registro será eliminado permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confir-mButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirma, hacer la petición AJAX
                $.ajax({
                    url: '{{ route("registrocombustible.destroy", ":id") }}'.replace(':id', registroId),  // Usar ruta definida
                    type: 'DELETE',                            // Método DELETE
                    data: {
                        _token: '{{ csrf_token() }}',           // Asegúrate de pasar el token CSRF
                    },
                    success: function(response) {
                        console.log('Respuesta AJAX:', response);  // Depuración
                        if (response.success) {
                            Swal.fire('Eliminado!', response.message, 'success');
                            
                            // Eliminar la fila correspondiente en la tabla
                            $('#registro-' + registroId).remove();
                            
                            // Recargar la página para reflejar los cambios
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Esperar 1 segundo antes de recargar la página
                        } else {
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

