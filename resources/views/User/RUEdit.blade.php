@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('contenido')

<style>  
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #000;
        font-size: 15px;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 50px auto;
        max-width: 550px;
    }
    
    .card-body {
        padding: 1.5rem;
        background-color: #fff;
        margin-top: -10px;
    }

    /* Form layout */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: -8px;
        margin-bottom: 0.25rem;
    }

    .form-group {
        flex: 1 1 100%;
        min-width: 250px;
        padding: 8px;
        margin-bottom: 0.25rem;
    }

    /* LABELS */
    .form-label {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
        color: #344767;
        font-size: 0.95rem !important;
        letter-spacing: 0.3px;
    }

    /* INPUTS */
    .form-control, .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        color: #344767;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0ea5e9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .text-danger {
        color: #dc3545;
        font-size: 0.75rem;
        margin-top: 2px;
        display: block;
    }
    
    /* Botones */
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: #344767;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-custom {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: #344767;  /* Color de texto igual al botón Regresar */
    }

    .btn-custom:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: white;  /* Cambia a blanco cuando se pasa el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }

    /* Estilo para botón btn-custom cuando está deshabilitado */
    .btn-custom:disabled {
        background-color: #0ea5e9 !important; /* Mismo azul */
        border-color: #0ea5e9 !important;
        color: #344767 !important; /* Mismo color de texto */
        opacity: 1 !important;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    /* Footer para botones */
    .d-flex {
        display: flex;
    }
    
    .justify-content-end {
        justify-content: flex-end;
    }
    
    .gap-3 {
        gap: 0.75rem;
    }
    
    /* Estilos específicos para el campo de contraseña */
    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }
    
    .input-group .form-control {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
    }
    
    .input-group .btn {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 4;
        padding: 0 0.75rem;
        background-color: transparent;
        border: none;
        color: #344767;
    }
    
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
    }
</style>

<div class="card p-4">
    <form id="formEditarUsuario" method="POST" action="{{ route('user.update', $usuario->id) }}">
        @csrf
        @method('PUT')

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Editar usuario</h3>
        </div>

        <div class="card-body">
            <!-- Campo Nombre -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nombreUsuario">Nombre:</label>
                    <input type="text" id="nombreUsuario" name="nombre" class="form-control" value="{{ $usuario->name }}" required>
                </div>
            </div>

            <!-- Campo Rol -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="rolUsuario">Rol:</label>
                    <select id="rolUsuario" name="rol" class="form-select" required>
                        <option value="Administrador" {{ $usuario->role == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Usuario" {{ $usuario->role == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                        <option value="Visualizador" {{ $usuario->role == 'Visualizador' ? 'selected' : '' }}>Visualizador</option>
                    </select>
                </div>
            </div>

            <!-- Campo Nueva Contraseña -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="passwordUsuario">Nueva contraseña (opcional):</label>
                    <div class="input-group">
                        <input type="password" id="passwordUsuario" name="password" class="form-control">
                        <button type="button" class="btn toggle-password" data-target="passwordUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Campo Confirmar Contraseña -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="passwordConfirmUsuario">Confirmar contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordConfirmUsuario" name="password_confirmation" class="form-control">
                        <button type="button" class="btn toggle-password" data-target="passwordConfirmUsuario">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones alineados a la derecha -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" id="btnActualizarUsuario" class="btn btn-custom">
                <i class="fas fa-sync-alt me-1"></i> Actualizar
            </button>
        </div>
    </form>
</div>

<script>
    // Deshabilitar de actualizar
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("formEditarUsuario");
        const submitButton = document.querySelector("button[type='submit']"); 

        // Deshabilitar el botón al inicio
        submitButton.disabled = true;

        // Guardar valores originales
        const initialFormData = new FormData(form);

        form.addEventListener("input", function () {
            const currentFormData = new FormData(form);
            let hasChanges = false;

            // Comparar los valores actuales con los originales
            for (let [key, value] of currentFormData.entries()) {
                if (value !== initialFormData.get(key)) {
                    hasChanges = true;
                    break;
                }
            }

            // Habilitar o deshabilitar el botón según haya cambios
            submitButton.disabled = !hasChanges;
        });
    });

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
