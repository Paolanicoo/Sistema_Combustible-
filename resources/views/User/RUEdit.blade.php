@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('contenido')

<style>  
    /* Estilos base */
    body { /** Estilos para el cuerpo de la página **/
    font-family: 'Poppins', sans-serif; /** Fuente utilizada **/
    background-color: #f8f9fa; /** Color de fondo **/
    color: #000; /** Color del texto **/
    font-size: 15px; /** Tamaño de la fuente **/
}

    .card { /** Estilos para la tarjeta principal **/
    border-radius: 12px; /** Bordes redondeados **/
    border: none; /** Sin borde **/
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /** Sombra **/
    overflow: hidden; /** Oculta el desbordamiento **/
    margin: 50px auto; /** Margen superior e inferior, centrado horizontalmente **/
    max-width: 550px; /** Ancho máximo **/
}
    
    .card-body { /** Estilos para el cuerpo de la tarjeta **/
    padding: 1.5rem; /** Padding interno **/
    background-color: #fff; /** Fondo blanco **/
    margin-top: -10px; /** Margen superior negativo **/
}

   .form-row { /** Estilos para la fila del formulario **/
    display: flex; /** Usar flexbox **/
    flex-wrap: wrap; /** Permitir que los hijos se envuelvan **/
    margin: -8px; /** Margen negativo para compensar el padding interno **/
    margin-bottom: 0.25rem; /** Margen inferior **/
}
   .form-group { /** Estilos para los grupos dentro del formulario **/
    flex: 1 1 100%; /** Ocupa 100% del ancho posible **/
    min-width: 250px; /** Ancho mínimo de 250px **/
    padding: 8px; /** Padding interno **/
    margin-bottom: 0.25rem; /** Margen inferior **/
}

    .form-label { /** Estilos para las etiquetas de los campos **/
    display: block; /** Mostrar como bloque **/
    margin-bottom: 4px; /** Margen inferior **/
    font-weight: 600; /** Negrita **/
    color: #344767; /** Color texto **/
    font-size: 0.95rem !important; /** Tamaño fuente **/
    letter-spacing: 0.3px; /** Espaciado entre letras **/
}

    .form-control, .form-select { /** Estilos para inputs y selects **/
    width: 100%; /** Ancho completo **/
    padding: 8px 12px; /** Padding interno **/
    border: 1px solid #e2e8f0; /** Borde gris claro **/
    border-radius: 8px; /** Bordes redondeados **/
    font-size: 0.9rem; /** Tamaño de fuente **/
    transition: all 0.3s ease; /** Transiciones suaves **/
    color: #344767; /** Color texto **/
}
    .form-control:focus, .form-select:focus { /** Al enfocar inputs y selects **/
    border-color: #0ea5e9; /** Borde azul **/
    outline: none; /** Sin contorno **/
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /** Sombra azul **/
}
    
   .form-control.is-invalid { /** Inputs con errores **/
    border-color: #dc3545; /** Borde rojo **/
}
    
    .text-danger { /** Texto de error **/
    color: #dc3545; /** Rojo **/
    font-size: 0.75rem; /** Tamaño pequeño **/
    margin-top: 2px; /** Margen arriba **/
    display: block; /** Mostrar como bloque **/
}
    
   .btn { /** Estilos generales para botones **/
    padding: 0.5rem 1rem; /** Padding **/
    border-radius: 8px; /** Bordes redondeados **/
    font-weight: 600; /** Negrita **/
    font-size: 0.9rem; /** Tamaño fuente **/
    transition: all 0.3s ease; /** Transición suave **/
    display: flex; /** Flexbox **/
    align-items: center; /** Verticalmente centrado **/
    justify-content: center; /** Horizontalmente centrado **/
    gap: 8px; /** Espacio entre icono y texto **/
}

   .btn-secondary { /** Botón secundario **/
    background-color: #f1f5f9; /** Fondo gris claro **/
    color: #344767; /** Color texto **/
    border: none; /** Sin borde **/
}

    .btn-secondary:hover { /** Al pasar el cursor **/
    background-color: #e2e8f0; /** Fondo gris más oscuro **/
    transform: translateY(-2px); /** Leve desplazamiento arriba **/
}

   .btn-custom { /** Botón personalizado **/
    background-color: #0ea5e9; /** Azul **/
    border-color: #0ea5e9; /** Azul **/
    color: #344767; /** Color texto gris oscuro **/
}

    .btn-custom:hover { /** Al pasar el cursor **/
    background-color: #0284c7; /** Azul oscuro **/
    border-color: #0284c7; /** Borde azul oscuro **/
    color: white; /** Texto blanco **/
    box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /** Sombra azul clara **/
    transform: translateY(-2px); /** Leve desplazamiento arriba **/
}

    .btn-custom:disabled { /** Botón personalizado deshabilitado **/
    background-color: #0ea5e9 !important; /** Azul **/
    border-color: #0ea5e9 !important; /** Borde azul **/
    color: #344767 !important; /** Texto gris **/
    opacity: 1 !important; /** Opacidad completa **/
    cursor: not-allowed; /** Cursor no permitido **/
    pointer-events: none; /** Sin interacción **/
}
    
    .d-flex { /** Elementos flexibles **/
    display: flex; /** Flexbox **/
}
.justify-content-end { /** Justificación al final **/
    justify-content: flex-end; /** Alineación al final **/
}
.gap-3 { /** Espacio entre elementos **/
    gap: 0.75rem; /** 0.75 rem **/
}
    
    .input-group { /** Grupo para inputs con botón **/
    position: relative; /** Relativo **/
    display: flex; /** Flexbox **/
    flex-wrap: wrap; /** Permitir envolver **/
    align-items: stretch; /** Estirar hijos **/
    width: 100%; /** Ancho completo **/
}
.input-group .form-control { /** Input dentro del grupo **/
    position: relative; /** Relativo **/
    flex: 1 1 auto; /** Flexible **/
    width: 1%; /** Ancho mínimo **/
    min-width: 0; /** Sin mínimo **/
}
    .input-group .btn { /** Botón dentro del grupo **/
    position: absolute; /** Absoluto **/
    right: 0; /** Derecha **/
    top: 0; /** Arriba **/
    bottom: 0; /** Abajo **/
    z-index: 4; /** Sobreposición **/
    padding: 0 0.75rem; /** Padding horizontal **/
    background-color: transparent; /** Transparente **/
    border: none; /** Sin borde **/
    color: #344767; /** Gris oscuro **/
}
    
   @media (max-width: 768px) { /** Responsive para móviles **/
    .form-group { /** Grupo de formulario **/
        flex: 1 1 100%; /** Usar ancho completo **/
    }
    }
</style>

<div class="card p-4">
    <form id="formEditarUsuario" method="POST" action="{{ route('user.update', $usuario->id) }}"> <!-- Formulario para editar un usuario, con método POST y acción para actualizar -->
        @csrf
        @method('PUT')

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Editar usuario</h3>  <!-- Título del formulario -->
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
            button.addEventListener("click", function() { // Agrega un evento de clic a cada botón.
                let target = document.getElementById(this.getAttribute("data-target")); // Obtiene el campo de contraseña correspondiente.
                let icon = this.querySelector("i"); // Obtiene el icono del botón.
                
                if (target.type === "password") { // Si el tipo es password.
                    target.type = "text"; // Cambia a texto.
                    icon.classList.remove("fa-eye"); // Cambia el icono a ojo cerrado.
                    icon.classList.add("fa-eye-slash");// Cambia el icono a ojo abierto.
                } else {
                    target.type = "password"; // Cambia a password.
                    icon.classList.remove("fa-eye-slash"); // Cambia el icono a ojo abierto.
                    icon.classList.add("fa-eye"); // Cambia el icono a ojo cerrado.
                }
            });
        });

        // Mantiene el script original de edición de usuario.
        document.getElementById("btnActualizarUsuario").addEventListener("click", function(event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente.

            Swal.fire({ // Muestra un cuadro de confirmación
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

        function enviarFormulario() { // Función para enviar el formulario
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
            .then(response => response.json())  // Convierte la respuesta a JSON
            .then(data => { // Maneja los datos de la respuesta
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
                } else { // Si hay un error
                    let mensaje = "No se pudo actualizar el usuario"; // Mensaje por defecto
                    if (data.errors) {
                        mensaje = Object.values(data.errors).flat().join("\n");
                    } else if (data.message) {
                        mensaje = data.message;
                    }
                    Swal.fire("Error", mensaje, "error"); // Muestra un cuadro de error
                }
            })
            .catch(error => { // Maneja errores de la solicitud
                console.error("Error:", error); // Muestra el error en la consola
                Swal.fire("Error", "Ocurrió un error inesperado", "error"); // Muestra un cuadro de error
            });
        }
    });
</script>

@endsection
