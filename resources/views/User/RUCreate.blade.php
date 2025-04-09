@extends('layouts.app')

@section('titulo', 'Crear Usuario')

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
    <form id="formCrearUsuario">
        @csrf

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Registro de usuario</h3>
        </div>

        <div class="card-body">
            <!-- Campo Nombre -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nombreUsuario">Nombre:</label>
                    <input type="text" id="nombreUsuario" name="nombre" class="form-control" 
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                    title="Solo se permiten letras y espacios"
                    maxlength="15">
                </div>
            </div>

            <!-- Campo Rol -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="rolUsuario">Rol:</label>
                    <select id="rolUsuario" name="rol" class="form-select" required>
                        <option value="">Seleccione un rol</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Visualizador">Visualizador</option>
                    </select>
                </div>
            </div>

            <!-- Campo Contraseña -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="passwordUsuario">Contraseña:</label>
                    <div class="input-group">
                        <input type="password" id="passwordUsuario" name="password" class="form-control" required>
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
                        <input type="password" id="passwordConfirmUsuario" name="password_confirmation" class="form-control" required>
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
            <button type="button" id="btnGuardarUsuario" class="btn btn-custom">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </form>
</div>

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
