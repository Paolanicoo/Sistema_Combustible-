<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Modal para crear un nuevo usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCrearUsuario">
                    @csrf
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombre" required>
                        <div id="nombreFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                    <label for="rolUsuario" class="form-label">Rol</label>
                        <select class="form-control" id="rolUsuario" name="rol" required>
                            <option value="">Seleccione un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Usuario">Usuario</option>
                            <option value="Visualizador">Visualizador</option>
                        </select>
                        <div id="rolFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordUsuario" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="passwordUsuario" name="password" required>
                        <div id="passwordFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="passwordConfirmUsuario" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="passwordConfirmUsuario" name="password_confirmation" required>
                        <div id="passwordConfirmFeedback" class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardarUsuario" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para resetear el formulario y los errores
    function resetFormulario() {
        document.getElementById("formCrearUsuario").reset();
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    // Obtener la instancia del modal usando la API de Bootstrap 5
    const modalElement = document.getElementById('modalCrearUsuario');
    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

    // Resetear formulario cuando se cierra el modal
    modalElement.addEventListener('hidden.bs.modal', function() {
        resetFormulario();
    });

    // Manejar el envío del formulario
    document.getElementById("btnGuardarUsuario").addEventListener("click", function() {
        let nombre = document.getElementById("nombreUsuario").value;
        let rol = document.getElementById("rolUsuario").value;
        let password = document.getElementById("passwordUsuario").value;
        let passwordConfirm = document.getElementById("passwordConfirmUsuario").value;
        
        // Validar que las contraseñas coincidan
        if (password !== passwordConfirm) {
            document.getElementById("passwordConfirmUsuario").classList.add('is-invalid');
            document.getElementById("passwordConfirmFeedback").textContent = "Las contraseñas no coinciden";
            return;
        }

        // Obtener el token CSRF
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        
        // Crear FormData para enviar los datos
        let formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('rol', rol);
        formData.append('password', password);
        formData.append('password_confirmation', passwordConfirm);
        formData.append('_token', token);

        fetch("{{ route('user.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Éxito",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    modal.hide();
                    
                    // Recargar la tabla de DataTables
                    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#users-table')) {
                        $('#users-table').DataTable().ajax.reload();
                    } else {
                        // Si por alguna razón la tabla no es una instancia de DataTable, recarga la página
                        location.reload();
                    }
                });
            } else {
                // Manejar errores de validación
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        let field = key === 'nombre' ? 'nombreUsuario' :
                                key === 'rol' ? 'rolUsuario' : 
                                key === 'password' ? 'passwordUsuario' :
                                key === 'password_confirmation' ? 'passwordConfirmUsuario' : '';
                        
                        if (field) {
                            document.getElementById(field).classList.add('is-invalid');
                            document.getElementById(field + 'Feedback').textContent = data.errors[key][0];
                        }
                    });
                } else {
                    Swal.fire("Error", "No se pudo crear el usuario", "error");
                }
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire("Error", "Ocurrió un error al procesar la solicitud", "error");
        });
    });
});
</script>