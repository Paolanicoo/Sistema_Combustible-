@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}} 

@section('titulo', 'Editar Vehículo') {{-- Título de la página --}}

@section('contenido') {{-- Contenido de la página --}}

@include('sweetalert::alert') {{-- Incluye el paquete de alertas --}}

<style>  
    /* Estilo base */
    body {
        font-family: 'Poppins', sans-serif; /* Tipo de fuente. */
        background-color: #f8f9fa; /* Color de fondo. */
        color: #000; /* Color del texto. */
        font-size: 15px; /* Tamaño de fuente. */
    }

    /* Estilo de la tarjeta */
    .card {
        border-radius: 12px; /* Radio del borde de la tarjeta. */
        border: none; /* Elimina el borde de la tarjeta. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra de la tarjeta. */
        overflow: hidden; /* Oculta el contenido que excede el tamaño de la tarjeta. */
        margin: 50px auto; /* Margen superior y automático. */
        max-width: 700px; /* Ancho máximo de la tarjeta. */
    }
    
    /* Estilo del cuerpo de la tarjeta */
    .card-body {
        padding: 1.5rem; /* Padding interno de la tarjeta. */
        background-color: #fff; /* Color de fondo de la tarjeta. */
        margin-top: -10px; /* Reduce el margen superior para acercar el formulario al título. */
    }

    /* Form layout - más compacto */
    .form-row {
        display: flex; /* Muestra los grupos de formularios en una fila. */
        flex-wrap: wrap; /* Permite que los grupos se ajusten al tamaño de la pantalla. */
        margin: -8px; /* Reduce el margen entre los grupos. */
        margin-bottom: 0.25rem; /* Reduce el margen inferior. */
    }

    /* Estilo de los grupos de formularios */
    .form-group {
        flex: 1 1 calc(50% - 16px); /* Ajusta el ancho de los grupos de formularios. */
        min-width: 250px; /* Ancho mínimo de los grupos de formularios. */
        padding: 8px; /* Padding interno de los grupos de formularios. */
        margin-bottom: 0.25rem; /* Reduce el margen inferior. */
    }

    /* Estilo de los labels */
    .form-label {
        display: block; /* Muestra los labels como bloques. */
        margin-bottom: 4px; /* Reduce el margen inferior. */
        font-weight: 600; /* Peso del texto del label. */
        color: #344767; /* Color del texto del label. */
        font-size: 0.95rem !important; /* Tamaño del texto del label. */
        letter-spacing: 0.3px; /* Espaciado entre letras del texto del label. */
    }

    /* Estilo de los inputs */
    .form-control {
        width: 100%; /* Ancho del input. */
        padding: 8px 12px; /* Padding interno del input. */
        border: 1px solid #e2e8f0; /* Borde del input. */
        border-radius: 8px; /* Radio del borde del input. */
        font-size: 0.9rem; /* Tamaño del texto del input. */
        transition: all 0.3s ease; /* Transición suave al cambiar el estado del input. */
        color: #344767; /* Color del texto del input. */
    }
    
    /* Estilo de los inputs */
    .form-control:focus {
        border-color: #0ea5e9; /* Cambia el color del borde al azul al enfocar el campo. */
        outline: none; /* Elimina el contorno predeterminado del navegador. */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Añade una sombra azul clara alrededor del campo enfocado. */
    }
    
    /* Estilo de los inputs */
    .form-control.is-invalid {
        border-color: #dc3545; /* Cambia el color del borde a rojo si hay un error de validación. */
    }
    
    /* Estilo de los inputs */
    .text-danger {
        color: #dc3545; /* Color rojo para mensajes de error. */
        font-size: 0.75rem; /* Tamaño del texto del mensaje de error. */
        margin-top: 2px; /* Margen superior del mensaje de error. */
        display: block; /* Muestra el mensaje de error como un bloque. */
    }
    
    /* Estilo de los textarea */
    textarea.form-control {
        height: 80px; /* Altura del textarea. */
        resize: vertical; /* Permite redimensionar el textarea verticalmente. */
    }
    
    /* Estilo de los botones */
    .btn {
        padding: 0.5rem 1rem; /* Padding interno del botón. */
        border-radius: 8px; /* Radio del borde del botón. */
        font-weight: 600; /* Peso del texto del botón. */
        font-size: 0.9rem; /* Tamaño del texto del botón. */
        transition: all 0.3s ease; /* Transición suave al cambiar el estado del botón. */
        display: flex; /* Muestra los botones como bloques. */  
        align-items: center; /* Alinea los botones verticalmente. */
        justify-content: center; /* Alinea los botones horizontalmente. */
        gap: 8px; /* Espacio entre los botones. */
    }
    
    /* Botón secundario */
    .btn-secondary {
        background-color: #f1f5f9; /* Color de fondo del botón secundario. */
        color: #344767; /* Color del texto del botón secundario. */
        border: none; /* Elimina el borde del botón secundario. */
    }
    
    /* Botón secundario al pasar el mouse */
    .btn-secondary:hover {
        background-color: #e2e8f0; /* Color de fondo del botón secundario al pasar el cursor. */
        transform: translateY(-2px); /* Eleva el botón al pasar el cursor. */
    }
    
    /* Botón personalizado */
    .btn-custom, .btn-info {
        background-color: #0ea5e9; /* Color de fondo del botón personalizado. */
        border-color: #0ea5e9; /* Color del borde del botón personalizado. */
        color: #344767; /* Color del texto del botón personalizado. */
    }

        .btn-custom:hover, .btn-info:hover {
        background-color: #0284c7; /* Cambia a azul oscuro cuando se pasa el cursor. */
        border-color: #0284c7; /* Cambia a azul oscuro cuando se pasa el cursor. */
        color: white; /* Letras blancas al pasar el cursor. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el cursor. */
        transform: translateY(-2px); /* Eleva el botón al pasar el cursor. */
    }
    
    /* Muestra botones en una fila */
    .d-flex {
        display: flex; /* Muestra los botones como bloques. */
    }
    
    /* Justifica botones a la derecha */
    .justify-content-end {
        justify-content: flex-end; /* Alinea botones a la derecha */
    }
    
    /* Espacio entre botones */
    .gap-3 {
        gap: 0.75rem; /* Espacio entre botones. */
    }
    
    /* Media query para dispositivos móviles */
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%; /* Ajuste para móviles.*/
        }
    }
</style>

<!-- Contenedor de la tarjeta -->
<div class="card p-4">
    <form method="post" action="{{ route('registrovehicular.update', $registro->id) }}" id="vehicle-form">
        @csrf
        @method('PUT')
        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Editar registro de vehículo</h3>
        </div>

        <div class="card-body">
            <!-- Primera fila: Equipo y Placa -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="equipo">Equipo</label>
                    <input type="text" id="equipo" name="equipo" 
                           class="form-control @error('equipo') is-invalid @enderror" 
                           value="{{ old('equipo', $registro->equipo) }}" maxlength="20">
                    @error('equipo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" value="{{ old('placa', $registro->placa) }}" oninput="formatPlaca(this)">
                @error('placa')
                     <div class="text-danger">{{ $message }}</div>
                 @enderror
                </div>
            </div>

            <!-- Segunda fila: Motor y Marca -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="motor">Motor</label>
                    <input type="text" id="motor" name="motor" 
                           class="form-control @error('motor') is-invalid @enderror" 
                           value="{{ old('motor', $registro->motor) }}" maxlength="35">
                    @error('motor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" 
                           class="form-control @error('marca') is-invalid @enderror" 
                           value="{{ old('marca', $registro->marca) }}" maxlength="25">
                    @error('marca')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Tercera fila: Modelo y Serie -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" 
                           class="form-control @error('modelo') is-invalid @enderror" 
                           value="{{ old('modelo', $registro->modelo) }}" maxlength="30">
                    @error('modelo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="serie">Serie</label>
                    <input type="text" id="serie" name="serie" 
                           class="form-control @error('serie') is-invalid @enderror" 
                           value="{{ old('serie', $registro->serie) }}" maxlength="25">
                    @error('serie')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Cuarta fila: Asignado y Observación -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="asignado">Asignado</label>
                    <input type="text" id="asignado" name="asignado" 
                           class="form-control @error('asignado') is-invalid @enderror" 
                           value="{{ old('asignado', $registro->asignado) }}" maxlength="30">
                    @error('asignado')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="observacion">Observación</label>
                    <textarea id="observacion" name="observacion" 
                              class="form-control @error('observacion') is-invalid @enderror" 
                              maxlength="40">{{ old('observacion', $registro->observacion) }}</textarea>
                    @error('observacion')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones alineados a la derecha -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" class="btn btn-info">
                <i class="fas fa-sync-alt me-1"></i> Actualizar
            </button>
        </div>
    </form>
</div>

   
<script>
    //Formateo de la placa.
    function formatPlaca(input) {
        let value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, ""); // Solo letras y números.

        // Evitar que inicie con números.
        if (value.length > 0 && !isNaN(value[0])) {
            value = value.substring(1);  // Elimina el primer número si empieza con uno.
        }

        // Limita las letras a solo las primeras 3.
        if (value.length > 3) {
            value = value.slice(0, 3) + " " + value.slice(3); // Añade espacio después de las primeras 3 letras.
        }

        // Asegurarse que después del espacio solo haya números.
        if (value.indexOf(" ") !== -1) {
            let parts = value.split(" "); // Separa la parte antes y después del espacio.
            parts[0] = parts[0].slice(0, 3).replace(/[^A-Z]/g, ""); // Limita la parte antes del espacio a solo 3 letras
            parts[1] = parts[1].replace(/[^0-9]/g, ""); // La parte después del espacio solo números.
            value = parts.join(" "); // Vuelve a juntar las partes.
        }

        // Limita la longitud total a 8 caracteres.
        if (value.length > 8) {
            value = value.slice(0, 8);
        }

        input.value = value.trim(); // Elimina espacios extra al final.
    }

    // Deshabilita el botón de actualizar, solo se habilita si hay cambios.
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("vehicle-form");
        const submitButton = document.querySelector("button[type='submit']");
        const placaInput = document.getElementById("placa");

        // Deshabilitar el botón al inicio.
        submitButton.disabled = true;

        // Guardar valores originales.
        const initialFormData = new FormData(form);

        form.addEventListener("input", function () {
            const currentFormData = new FormData(form);
            let hasChanges = false;

            // Comparar los valores actuales con los originales.
            for (let [key, value] of currentFormData.entries()) {
                if (value !== initialFormData.get(key)) {
                    hasChanges = true;
                    break;
                }
            }

            // Habilitar o deshabilitar el botón según haya cambios.
            submitButton.disabled = !hasChanges;
        });

        // No aplicar el formato al cargar la página si la placa no ha cambiado.
        if (placaInput.value) {
            placaInput.addEventListener("input", function () {
                formatPlaca(this);
            });
        }
    });
</script>

@endsection
