@extends('layouts.app')

@section('titulo', 'Crear Usuario')

@section('contenido')

<style>  
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /*Fuente utilizada*/
        background-color: #f8f9fa; /*Color de fondo*/
        color: #000; /*Color del texto*/
        font-size: 15px; /*Tamaño de la fuente*/
    }

    .card { /* Estilos para la tarjeta principal*/
        border-radius: 12px; /*Bordes redondeados*/
        border: none; /*Sin borde*/
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /*Sombra*/
        overflow: hidden; /*Oculta el desbordamiento*/
        margin: 50px auto; /*Margen superior e inferior de 50px, centrado horizontalmente*/
        max-width: 550px;/* Ancho máximo de la tarjeta*/
    }
    
    .card-body { /*Estilos para el cuerpo de la tarjeta*/
        padding: 1.5rem; /**/
        background-color: #fff;/*Color de fondo blanco*/
        margin-top: -10px; /*Margen superior negativo*/
    }

    /* Estilos para la fila del formulario */
    .form-row {
        display: flex; 
        flex-wrap: wrap; /* Permitir que los elementos se envuelvan*/
        margin: -8px; /* Margen negativo para compensar el padding*/
        margin-bottom: 0.25rem; /*// Margen inferior*/
    }

    .form-group { /*Estilos para los grupos de formulario*/
        flex: 1 1 100%; /*Ocupa el 100% del ancho*/
        min-width: 250px; /*Ancho mínimo de 250px*/
        padding: 8px; /*Padding interno*/
        margin-bottom: 0.25rem; /*Margen inferior*/
    }

    /* Estilos para las etiquetas de los campos */
    .form-label { 
        display: block; /*Mostrar como bloque*/
        margin-bottom: 4px; /*Margen inferior*/
        font-weight: 600; /*Peso de la fuente*/
        color: #344767; /*Color del texto*/
        font-size: 0.95rem !important; /*Tamaño de la fuente*/
        letter-spacing: 0.3px; /*Espaciado entre letras*/
    }

    /* Estilos para los inputs y selects */
    .form-control, .form-select { 
        width: 100%; /*Ancho completo*/
        padding: 8px 12px; /*Padding interno*/
        border: 1px solid #e2e8f0; /* Borde*/
        border-radius: 8px; /*Bordes redondeados*/ 
        font-size: 0.9rem; /*Tamaño de la fuente*/
        transition: all 0.3s ease; /*Transición suave*/
        color: #344767;/*Color de texto*/
    }
    
    .form-control:focus, .form-select:focus { /*Estilos al tener foco en inputs y selects*/
        border-color: #0ea5e9;/*Color del borde al enfocar*/
        outline: none;/*Sin contorno*/
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);/*Sombra al enfocar*/
    }
    
    .form-control.is-invalid { 
        border-color: #dc3545;/*Color del borde para errores*/
    }
    
    .text-danger { /*Estilos para mensajes de error*/
        color: #dc3545; /*Color*/
        font-size: 0.75rem; /*Tamaño de la fuente*/
        margin-top: 2px; /*Margen superior*/
        display: block; /*Mostrar como bloque*/
    }
    
    /* Botones */
    .btn { /* Estilos generales para todos los botones */
    padding: 0.5rem 1rem; /* Padding interno del botón */
    border-radius: 8px; /* Bordes redondeados */
    font-weight: 600; /* Peso de la fuente */
    font-size: 0.9rem; /* Tamaño de la fuente */
    transition: all 0.3s ease; /* Transición suave para todos los cambios */
    display: flex; /* Usar flexbox para alinear contenido */
    align-items: center; /* Alinear verticalmente al centro */
    justify-content: center; /* Centrar horizontalmente */
    gap: 8px; /* Espacio entre elementos dentro del botón */
}
    .btn-secondary { /* Estilos para el botón secundario */
    background-color: #f1f5f9; /* Color de fondo gris claro */
    color: #344767; /* Color del texto gris oscuro */
    border: none; /* Sin borde */
}
.btn-secondary:hover { /* Estilos al pasar el mouse sobre el botón secundario */
    background-color: #e2e8f0; /* Color de fondo gris más oscuro */
    transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba */
}

   .btn-custom { /* Estilos para el botón personalizado */
    background-color: #0ea5e9; /* Color de fondo azul */
    border-color: #0ea5e9; /* Color del borde azul */
    color: #344767;  /* Color de texto igual al botón Regresar */
}
.btn-custom:hover { /* Estilos al pasar el mouse sobre el botón personalizado */
    background-color: #0284c7; /* Color de fondo azul oscuro */
    border-color: #0284c7; /* Color del borde azul oscuro */
    color: white;  /* Cambia a blanco cuando se pasa el cursor */
    box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse */
    transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba */
}
    
    /* Footer para botones */
    .d-flex { /* Estilos para contenedores flexibles */
    display: flex; /* Usar flexbox */
}
.justify-content-end { /* Estilos para alinear contenido al final */
    justify-content: flex-end; /* Alinear al final */
}
.gap-3 { /* Estilos para espacio entre elementos */
    gap: 0.75rem; /* Espacio entre elementos */
}
    
    .input-group { /* Estilos para el grupo de entrada de contraseña */
    position: relative; /* Posición relativa para el contenedor */
    display: flex; /* Usar flexbox */
    flex-wrap: wrap; /* Permitir que los elementos se envuelvan */
    align-items: stretch; /* Estirar elementos para que ocupen el mismo alto */
    width: 100%; /* Ancho completo */
}
.input-group .form-control { /* Estilos para el input dentro del grupo */
    position: relative; /* Posición relativa */
    flex: 1 1 auto; /* Flexibilidad para el input */
    width: 1%; /* Ancho flexible */
    min-width: 0; /* Sin ancho mínimo */
}
    
   .input-group .btn { /* Estilos para el botón dentro del grupo de entrada */
    position: absolute; /* Posición absoluta para superposición */
    right: 0; /* Alinear a la derecha */
    top: 0; /* Alinear en la parte superior */
    bottom: 0; /* Alinear en la parte inferior */
    z-index: 4; /* Z-index para superposición */
    padding: 0 0.75rem; /* Padding horizontal */
    background-color: transparent; /* Fondo transparente */
    border: none; /* Sin borde */
    color: #344767; /* Color del texto */
}
    @media (max-width: 768px) { /* Estilos para pantallas pequeñas */
    .form-group { /* Estilos para grupos de formulario */
        flex: 1 1 100%; /* Ocupa el 100% del ancho */
        }
    }
</style>

<div class="card p-4">
    <form id="formCrearUsuario">
        @csrf

        <!-- Título centrado con fondo gris claro. -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Registro de usuario</h3>
        </div>

        <div class="card-body">
            <!-- Campo Nombre. -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nombreUsuario">Nombre:</label>
                    <input type="text" id="nombreUsuario" name="nombre" class="form-control" 
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                    title="Solo se permiten letras y espacios"
                    maxlength="15">
                </div>
            </div>

            <!-- Campo Rol. -->
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

            <!-- Campo Contraseña. -->
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

            <!-- Campo Confirmar Contraseña. -->
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

        <!-- Botones alineados a la derecha. -->
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
document.addEventListener('DOMContentLoaded', function() { // Espera a que el DOM esté completamente cargado.
    // Mostrar/ocultar contraseña.
    document.querySelectorAll(".toggle-password").forEach(button => {
        button.addEventListener("click", function() { // Agrega un evento de clic a cada botón.
            let target = document.getElementById(this.getAttribute("data-target"));// Obtiene el campo de contraseña correspondiente.
            let icon = this.querySelector("i"); // Obtiene el icono del botón.
            
            if (target.type === "password") {  // Si el tipo es password.
                target.type = "text"; // Cambia a texto.
                icon.classList.remove("fa-eye"); // Cambia el icono a ojo cerrado.
                icon.classList.add("fa-eye-slash"); // Cambia el icono a ojo abierto.
            } else {
                target.type = "password"; // Cambia a password.
                icon.classList.remove("fa-eye-slash"); // Cambia el icono a ojo abierto.
                icon.classList.add("fa-eye"); // Cambia el icono a ojo cerrado.
            }
        });
    });

    // Guardar usuario con confirmación de SweetAlert.
    document.getElementById("btnGuardarUsuario").addEventListener("click", function() { // Agrega un evento de clic al botón de guardar.
        Swal.fire({ // Muestra un cuadro de confirmación
            title: "¿Guardar usuario?",
            text: "¿Estás seguro de que deseas crear este usuario?",
            icon: "warning", // Icono de advertencia
            showCancelButton: true, // Muestra el botón de cancelar
            confirmButtonText: "Sí, guardar", // Texto del botón de confirmar
            cancelButtonText: "Cancelar" // Texto del botón de cancelar
        }).then((result) => { // Maneja la respuesta del cuadro
            if (result.isConfirmed) { // Si se confirma
                enviarFormulario(); // Llama a la función para enviar el formulario
            }
        });
    });

    function enviarFormulario() { // Función para enviar el formulario
    let formData = new FormData(document.getElementById("formCrearUsuario")); // Crea un objeto FormData con los datos del formulario.
    fetch("{{ route('user.store') }}", { // Realiza una solicitud POST a la ruta para guardar el usuario.
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json()) // Convierte la respuesta a JSON
    .then(data => { // Maneja los datos de la respuesta
        if (data.success) { // Si la respuesta es exitosa
            Swal.fire({  // Muestra un cuadro de éxito
                title: "Éxito",
                text: data.message || "Usuario creado correctamente",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                window.location.href = "{{ route('user.index') }}"; // Redirige a la lista de usuarios
            });
        } else { // Si hay un error
            let mensaje = "No se pudo crear el usuario"; // Mensaje por defecto
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
