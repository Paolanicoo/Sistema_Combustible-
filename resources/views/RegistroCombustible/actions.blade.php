<div class="d-flex gap-2">
@if(Auth::user()->role !== 'Visualizador') <!--Solo muestra los botones si el usuario no es Visualizador. -->
    <a href="{{ route('registrocombustible.edit', $registro->id) }}" class="btn btn-warning btn-sm" title="Editar"><!--Botón para editar el registro.  -->
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $registro->id }}" title="Eliminar"><!-- Botón de eliminar con data-id para usarlo en JS.  -->
        <i class="fas fa-trash"></i><!--Ícono de basurero. -->
    </button>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- Carga la librería de SweetAlert2. -->
<script>
    $(document).on('click', '.delete-btn', function () {
        var registroId = $(this).data('id'); // Obtiene el ID del registro.
        console.log('ID del registro:', registroId);  // Depuración.

        // Confirma la eliminación con SweetAlert.
        Swal.fire({
            title: '¿Estás seguro?',  // Título de la alerta.
            text: "¡Este registro será eliminado permanentemente!", // Mensaje descriptivo.
            icon: 'warning',  // Ícono de advertencia.
            showCancelButton: true, // Muestra botón para cancelar.
            confir-mButtonText: 'Sí, eliminar', // Texto del botón de confirmación.
            cancelButtonText: 'Cancelar', // Texto del botón de cancelación.
        }).then((result) => { // Espera la respuesta del usuario.
            if (result.isConfirmed) { // Si el usuario confirmó la eliminación.
                $.ajax({ // Inicia la petición AJAX.
                    url: '{{ route("registrocombustible.destroy", ":id") }}'.replace(':id', registroId),  // Usar ruta definida.
                    type: 'DELETE',                            // Método delete.
                    data: {
                        _token: '{{ csrf_token() }}',           // Asegúrate de pasar el token CSRF.
                    },
                    success: function(response) {
                        console.log('Respuesta AJAX:', response);  // Depuración.
                        if (response.success) {
                            Swal.fire('Eliminado!', response.message, 'success');
                            
                            // Eliminar la fila correspondiente en la tabla.
                            $('#registro-' + registroId).remove();
                            
                            // Recargar la página para reflejar los cambios.
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Esperar 1 segundo antes de recargar la página.
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) { // Si ocurre un error en la petición AJAX.
                        console.error(error); // Muestra el error en consola.
                        Swal.fire('Error!', 'Hubo un problema al eliminar el registro.', 'error');// Muestra mensaje de error.
                    }
                });
            }
        });
    });
</script>

