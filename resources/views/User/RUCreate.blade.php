@extends('layouts.app')

@section('titulo', 'Crear Usuario')

@section('contenido')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Crear Nuevo Usuario</h2>
            <a href="{{ route('user.index') }}" class="btn btn-light btn-sm">Volver</a>
        </div>
        <div class="card-body">
            <form id="formCrearUsuario">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" id="nombreUsuario" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select id="rolUsuario" name="rol" class="form-select" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Visualizador">Visualizador</option>
                    </select>
                </div>

                <!-- Campo de contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label">Contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordUsuario" name="password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Campo de confirmar contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordConfirmUsuario" name="password_confirmation" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordConfirmUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="button" id="btnGuardarUsuario" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts de SweetAlert y funcionalidad del botón de ojo -->
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

    // Guardar usuario con confirmación de SweetAlert
    document.getElementById("btnGuardarUsuario").addEventListener("click", function() {
        Swal.fire({
            title: "¿Guardar usuario?",
            text: "¿Estás seguro de que deseas crear este usuario?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFormulario();
            }
        });
    });

    function enviarFormulario() {
    let formData = new FormData(document.getElementById("formCrearUsuario"));

    fetch("{{ route('user.store') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "Éxito",
                text: data.message || "Usuario creado correctamente",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "{{ route('user.index') }}"; // Redirige a la lista de usuarios
            });
        } else {
            let mensaje = "No se pudo crear el usuario";
            if (data.errors) {
                mensaje = Object.values(data.errors).flat().join("\n"); // Muestra errores correctamente
            }
            Swal.fire("Error", mensaje, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire("Error", "Ocurrió un error al procesar la solicitud", "error");
    });
}

});
</script>

@endsection
