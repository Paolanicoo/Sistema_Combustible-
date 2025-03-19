@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('contenido')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Editar Usuario</h2>
            <a href="{{ route('user.index') }}" class="btn btn-light btn-sm">Volver</a>
        </div>
        <div class="card-body">
            <form id="formEditarUsuario" method="POST" action="{{ route('user.update', $usuario->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select name="rol" class="form-select" required>
                        <option value="Administrador" {{ $usuario->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Usuario" {{ $usuario->role == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                        <option value="Visualizador" {{ $usuario->role == 'Visualizador' ? 'selected' : '' }}>Visualizador</option>
                    </select>
                </div>

                <!-- Campo de contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña (Opcional):</label>
                    <div class="input-group">
                        <input type="password" id="passwordUsuario" name="password" class="form-control">
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Campo de confirmar contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordConfirmUsuario" name="password_confirmation" class="form-control">
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordConfirmUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-warning" id="btnActualizarUsuario">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts de SweetAlert y FontAwesome para los íconos -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña
    document.querySelectorAll(".toggle-password").forEach(button => {
        button.addEventListener("click", function() {
            let target = document.getElementById(this.getAttribute("data-target"));
            let icon = this.querySelector("i");
            
            if (target.type === "password") {
                target.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                target.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });

    // Mantiene el script original de edición de usuario
    document.getElementById("btnActualizarUsuario").addEventListener("click", function(event) {
        event.preventDefault(); // 🚀 Evita que el formulario se envíe automáticamente

        Swal.fire({
            title: "¿Actualizar usuario?",
            text: "¿Estás seguro de que deseas actualizar este usuario?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFormulario();
            }
        });
    });

    function enviarFormulario() {
        let form = document.getElementById("formEditarUsuario");
        let formData = new FormData(form);
        formData.append("_method", "PUT"); // 🚀 Laravel requiere este método para actualizar

        fetch(form.action, {
            method: "POST", // 🚀 Laravel espera POST con _method para PUT
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Éxito",
                    text: "Usuario actualizado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href = "{{ route('user.index') }}"; // 🚀 Redirige correctamente
                });
            } else {
                let mensaje = "No se pudo actualizar el usuario";
                if (data.errors) {
                    mensaje = Object.values(data.errors).flat().join("\n");
                }
                Swal.fire("Error", mensaje, "error");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire("Error", "Ocurrió un error inesperado", "error");
        });
    }
});
</script>

@endsection
