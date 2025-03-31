@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('contenido')

<style>
    /* Estilos generales */
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    .card {
        border-radius: 10px;
        max-width: 600px; /* Contenedor más pequeño */
        margin-top: 50px;
        margin-left: auto;
        margin-right: auto;
        background-color: #f9f9f9;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        min-height: 450px; /* Asegura que el tamaño del formulario se ajuste al contenido */
    }

    .card-header {
        color: #333; /* Cambié el color de fondo para que no sea negro */
        text-align: center;
        padding: 15px;
        font-size: 24px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-size: 16px; /* Tamaño más pequeño para las etiquetas */
        font-weight: bold;
    }

    .form-control, .form-select {
        font-size: 14px; /* Tamaño de fuente más pequeño para los campos de texto */
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #66afe9;
        outline: none;
    }

    .input-group {
        width: 100%;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .d-flex .btn {
        width: 45px;
        height: 45px;
    }
    
    /* Título centrado y con el mismo tamaño que en el primer formulario */
    .centered-title {
        text-align: center;
        font-weight: bold;
        font-size: 24px;
        margin-top: 20px;
        font-family: 'Arial', sans-serif;
    }

    /* Estilo para el botón de guardar en verde */
    .btn-custom {
        background-color: rgb(53, 192, 88);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        width: 100%;
        border: none;
    }

    .btn-custom:hover {
        background-color: rgb(40, 160, 70);
        transition: 0.3s ease-in-out;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
        font-size: 14px; /* Tamaño más pequeño para los inputs/selects */
    }

    .form-label {
    font-weight: bold;
    font-size: 16px; /* Tamaño igualado al otro formulario */
    font-family: 'Arial', sans-serif; /* Asegura la misma tipografía */
    }

    .form-control, .form-select {
        font-size: 16px; /* Ajustado al tamaño del otro formulario */
        font-family: 'Arial', sans-serif; /* Asegura la misma tipografía */
    }

</style>

<div class="container mt-4">
    <div class="card p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Editar usuario</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('user.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" id="btnActualizarUsuario" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form id="formEditarUsuario" method="POST" action="{{ route('user.update', $usuario->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="nombreUsuario">Nombre:</label>
                    <input type="text" id="nombreUsuario" name="nombre" class="form-control" value="{{ $usuario->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="rolUsuario">Rol:</label>
                    <select id="rolUsuario" name="rol" class="form-control" required>
                        <option value="Administrador" {{ $usuario->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Usuario" {{ $usuario->role == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                        <option value="Visualizador" {{ $usuario->role == 'Visualizador' ? 'selected' : '' }}>Visualizador</option>
                    </select>
                </div>

                <!-- Campo de contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label" for="passwordUsuario">Nueva Contraseña (Opcional):</label>
                    <div class="input-group">
                        <input type="password" id="passwordUsuario" name="password" class="form-control">
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Campo de confirmar contraseña con botón de ojo -->
                <div class="mb-3">
                    <label class="form-label" for="passwordConfirmUsuario">Confirmar Contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordConfirmUsuario" name="password_confirmation" class="form-control">
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="passwordConfirmUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
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
        event.preventDefault(); // Evita que el formulario se envíe automáticamente

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
        formData.append("_method", "PUT"); // Laravel requiere este método para actualizar

        fetch(form.action, {
            method: "POST", // Laravel espera POST con _method para PUT
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Verificar si hubo cambios o no
                if (data.noChanges) {
                    // No se detectaron cambios
                    Swal.fire({
                        title: "Sin cambios",
                        text: data.message || "No se detectaron modificaciones",
                        icon: "info",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "{{ route('user.index') }}";
                    });
                } else {
                    // Hubo cambios y se actualizó correctamente
                    Swal.fire({
                        title: "Éxito",
                        text: data.message || "Usuario actualizado correctamente",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "{{ route('user.index') }}";
                    });
                }
            } else {
                let mensaje = "No se pudo actualizar el usuario";
                if (data.errors) {
                    mensaje = Object.values(data.errors).flat().join("\n");
                } else if (data.message) {
                    mensaje = data.message;
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
