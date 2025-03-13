@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Editar Usuario</span>
                    <a href="{{ route('registrovehicular.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form id="formEditarUsuario">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="usuarioId" value="{{ $usuario->id }}">
                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombre" value="{{ $usuario->nombre }}" required>
                            <div id="nombreFeedback" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="rolUsuario" class="form-label">Rol</label>
                            <select class="form-control" id="rolUsuario" name="rol" required>
                                <option value="">Seleccione un rol</option>
                                <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="Editor" {{ $usuario->rol == 'Editor' ? 'selected' : '' }}>Editor</option>
                                <option value="Visualizador" {{ $usuario->rol == 'Visualizador' ? 'selected' : '' }}>Visualizador</option>
                            </select>
                            <div id="rolFeedback" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="passwordUsuario" class="form-label">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="password">
                            <div id="passwordFeedback" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="passwordConfirmUsuario" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="passwordConfirmUsuario" name="password_confirmation">
                            <div id="passwordConfirmFeedback" class="invalid-feedback"></div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="button" id="btnActualizarUsuario" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el envío del formulario de edición
    document.getElementById("btnActualizarUsuario").addEventListener("click", function() {
        // Limpiar feedbacks de error previos
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        
        let usuarioId = document.getElementById("usuarioId").value;
        let nombre = document.getElementById("nombreUsuario").value;
        let rol = document.getElementById("rolUsuario").value;
        let password = document.getElementById("passwordUsuario").value;
        let passwordConfirm = document.getElementById("passwordConfirmUsuario").value;
        
        // Validar que las contraseñas coincidan si se está cambiando
        if (password !== '' && password !== passwordConfirm) {
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
        formData.append('_token', token);
        formData.append('_method', 'PUT');
        
        // Agregar contraseña solo si se ha proporcionado una nueva
        if (password !== '') {
            formData.append('password', password);
            formData.append('password_confirmation', passwordConfirm);
        }

        fetch(`/registrovehicular/update/${usuarioId}`, {
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
                    text: data.message || "Usuario actualizado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    // Redireccionar a la página de listado
                    window.location.href = "{{ route('registrovehicular.index') }}";
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
                    Swal.fire("Error", data.message || "No se pudo actualizar el usuario", "error");
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
@endsection