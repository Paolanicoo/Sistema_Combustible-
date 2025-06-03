@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}}

@section('titulo','Editar registro combustible') {{-- Título de la página --}} 

@section('contenido') {{-- Contenido de la página --}}

<style>
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /* Define la fuente principal del sitio como 'Poppins'.*/
        background-color: #f8f9fa; /* Establece un color de fondo gris claro para la página. */
        color: #000;  /* Define el color del texto como negro. */             
        font-size: 15px; /* Establece el tamaño base del texto en 15 píxeles. */   
    }

    /* Tarjeta */
    .card {
        border-radius: 12px; /* Aplica bordes redondeados de 12 píxeles. */
        border: none; /* Elimina cualquier borde predeterminado. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Agrega una sombra suave alrededor de la tarjeta. */
        overflow: hidden; /* Oculta cualquier contenido que sobresalga del borde de la tarjeta. */
        margin: 50px auto; /* Aplica un margen vertical de 50px y centra horizontalmente. */
        max-width: 900px; /* Limita el ancho máximo de la tarjeta a 900 píxeles. */
    }

    /* Encabezado de la tarjeta */
    .card-header {
        background-color: #fff; /* Establece el fondo del encabezado de la tarjeta en blanco. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) /* Agrega una línea sutil en la parte inferior del encabezado. */
        padding: 1rem 1.5rem; /* Relleno interno */
        display: flex; /* Usa Flexbox para organizar botones */
        justify-content: center; /* Alinea los elementos horizontalmente al centro */
        align-items: center; /* Alinea los elementos verticalmente al centro */
    }

    /* Título centrado */
    .centered-title {
        color: #344767; /* Color del texto del título. */
        font-weight: 530; /* Peso de la fuente del título. */
        margin-bottom: 0; /* Elimina el margen inferior del título. */
        text-align: center; /* Alinea el texto del título al centro. */
    }

    /* Cuerpo de la tarjeta */
    .card-body {
        padding: 1.5rem; /* Aplica un relleno de 1.5rem dentro del cuerpo de la tarjeta. */
        background-color: #fff; /* Establece el fondo del cuerpo de la tarjeta en blanco. */
    }

    /* Labels */
    .form-label {
        display: block;  /* Hace que las etiquetas se comporten como bloques, ocupando todo el ancho disponible. */
        margin-bottom: 6px; /* Añade un margen inferior de 6 píxeles para separar las etiquetas de los campos de entrada. */
        font-weight: 600; /* Define el peso de la fuente como seminegrita. */
        color: #344767; /* Establece el color del texto de las etiquetas. */
        font-size: 1rem !important; /* Asegura que el tamaño de la fuente sea de 1 rem, sobrescribiendo cualquier otro estilo. */
        letter-spacing: 0.3px; /* Añade un espaciado entre letras de 0.3 píxeles para mejorar la legibilidad. */
    }

    /* Inputs */
    .form-control {
        width: 100%; /* Asegura que los campos de entrada ocupen todo el ancho disponible. */
        padding: 10px 12px; /* Añade un relleno de 10 píxeles en la parte superior e inferior y 12 píxeles a los lados. */
        border: 1px solid #e2e8f0; /* Establece un borde sutil de 1 píxel con un color gris claro. */
        border-radius: 8px; /* Aplica bordes redondeados de 8 píxeles. */
        font-size: 0.9375rem; /* Define el tamaño de la fuente como 0.9375 rem (15 píxeles). */
        transition: all 0.3s ease; /* Añade una transición suave para cambios de estilo. */
        color: #344767; /* Establece el color del texto de los campos de entrada. */
    }

    /* Formulario de validación */
    .form-control:focus {
        border-color: #0ea5e9; /* Cambia el color del borde al azul al enfocar el campo. */
        outline: none; /* Elimina el contorno predeterminado del navegador. */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Añade una sombra azul clara alrededor del campo enfocado. */
    }

    /* Formulario de validación */
    .form-control.is-invalid {
        border-color: #dc3545; /* Cambia el color del borde a rojo si hay un error de validación. */
    }

    /* Campos de solo lectura */
    .form-control[readonly],
    .form-control.read-only {
        background-color: #f1f1f1 !important; /* Fondo gris claro para campos de solo lectura. */
        color: #6c757d !important; /* Color de texto gris oscuro para campos de solo lectura. */
        cursor: not-allowed; /* Cambia el cursor a no permitido para indicar que el campo no es editable. */
        border: 1px solid #e2e8f0; /* Mantiene el borde sutil para campos de solo lectura. */
    }

    /* Mensajes de error */
    .text-danger {
        color: #dc3545; /* Color rojo para mensajes de error. */
        font-size: 0.8125rem; /* Tamaño de fuente más pequeño para mensajes de error. */
        margin-top: 4px; /* Añade un margen superior de 4 píxeles para separar el mensaje del campo. */
        display: block; /* Hace que el mensaje de error ocupe todo el ancho disponible. */
    }

    /* Mensajes de retroalimentación */
    .invalid-feedback {
        color: #dc3545; /* Color rojo para mensajes de retroalimentación de error. */
        font-size: 0.8125rem; /* Tamaño de fuente más pequeño para mensajes de retroalimentación. */
        margin-top: 4px; /* Añade un margen superior de 4 píxeles para separar el mensaje del campo. */
        display: block; /* Hace que el mensaje de retroalimentación ocupe todo el ancho disponible. */
    }

    /* Botones */
    .btn {
        padding: 0.5rem 1rem; /* Añade un relleno de 0.5rem en la parte superior e inferior y 1rem a los lados. */
        border-radius: 8px; /* Aplica bordes redondeados de 8 píxeles. */
        font-weight: 600; /* Define el peso de la fuente como seminegrita. */
        font-size: 0.9rem; /* Define el tamaño de la fuente como 0.9 rem (14.4 píxeles). */
        transition: all 0.3s ease;  /* Añade una transición suave para cambios de estilo. */
        display: flex; /* Hace que el botón sea un contenedor flexible. */
        align-items: center; /* Alinea los elementos dentro del botón verticalmente al centro. */
        justify-content: center; /* Alinea los elementos dentro del botón horizontalmente al centro. */
        gap: 8px; /* Añade un espacio de 8 píxeles entre los elementos dentro del botón. */
        color: #000; /* Texto negro por defecto */
    }

    /* Botón secundario */
    .btn-secondary {
        background-color: #f1f5f9;   
        color: #344767;   
        border: none;
    }

    /* Botón secundario al pasar el mouse */
    .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }

    /* Botón personalizado */
    .btn-custom {
        background-color: #0ea5e9; /* Fondo azul */
        border-color: #0ea5e9;  /* Borde azul */
        color: #000; /* Texto negro por defecto */
    }

    /* Botón personalizado al pasar el mouse */
    .btn-custom:hover {
        background-color: #0284c7; /* Azul más oscuro al interactuar */
        border-color: #0284c7; /* Borde azul oscuro */
        color: #ffffff !important; /* Texto blanco al pasar el mouse */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse */
        transform: translateY(-2px); /* Eleva el botón al pasar el mouse */
    }

    /* Botón personalizado al pasar el mouse */
    .btn-custom:hover i {
        color: #ffffff !important; /* También cambia el color del ícono */
    }

    /* Estilo para el botón deshabilitado */
    .btn[disabled], .btn:disabled {
        background-color: #0ea5e9 !important; /* Fondo azul */
        color: #000 !important; /* Texto negro */
        border-color: #0ea5e9 !important; /* Borde azul */
        cursor: not-allowed; /* Cursor no permitido */
        pointer-events: none; /* Desactiva las interacciones */
    }

    /* Textarea */
    textarea.form-control {
        height: 80px; /* Altura del textarea */  
        resize: vertical; /* Permite redimensionar verticalmente */
    }

    /* Botones de acción */
    .action-buttons {
        display: flex; /* Usa Flexbox para organizar botones */
        gap: 8px; /* Espacio entre botones */
        justify-content: flex-end; /* Alinea los botones al final (derecha) */
    }

    /* Botón de icono */
    .btn-icon {
        width: 40px; /* Ancho del botón */
        height: 40px; /* Alto del botón */
        padding: 0; /* Sin relleno */
        display: flex; /* Usa Flexbox para organizar botones */
        align-items: center; /* Alinea los elementos verticalmente al centro */
        justify-content: center; /* Alinea los elementos horizontalmente al centro */
        border-radius: 8px; /* Bordes redondeados */
    }

    /* Media queries para dispositivos móviles */
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%; /* Ajusta el ancho para móviles */
        }

        .form-label {
            font-size: 0.9375rem !important; /* Tamaño de fuente más pequeño */
        }
    }

    /* Estilo para el encabezado de la sección */
    .encabezado-seccion {
        background-color: #f0f0f0; /* Fondo gris claro */
        color: #344767; /* Color del texto */
        padding: 15px; /* Relleno interno */
        border-radius: 8px; /* Bordes redondeados */
        text-align: center; /* Centra el texto del encabezado */
        margin-bottom: 20px; /* Espacio entre el encabezado y el resto del formulario */
    }

    /*Estilo para cuando el botón de actualizar está deshabilitado*/
    .btn-custom:disabled,
    .btn-custom[disabled] {
        background-color: #0ea5e9 !important; /* Fondo azul */
        border-color: #0ea5e9 !important; /* Borde azul */
        color: #344767 !important; /* Texto gris oscuro */
        opacity: 1 !important; /* Asegura que no se vea opaco */
        cursor: not-allowed; /* Cursor no permitido */
        box-shadow: none; /* Elimina la sombra */
        transform: none; /* Elimina la transformación al pasar el mouse */
    }
</style>

<!-- Encabezado de la página. -->
<div class="card p-4">
    <form method="post" action="{{ route('registroimporte.update', $registro->id) }}" id="update-form">
        @csrf
        @method('PUT')
        <div class="encabezado-seccion">
            <h3 class="m-0">Editar resumen importe</h3>
        </div>
        <div class="mb-4"></div>
        <!-- Campo de fecha.-->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control read-only" value="{{ old('fecha', $registro->fecha ?? '') }}" readonly required>
            </div>
            <!-- Campo de vehículo. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}"
                            data-equipo="{{ $vehiculo->equipo }}"
                            data-placa="{{ $vehiculo->placa }}"
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}"
                            {{ $vehiculo->id == $registro->id_registro_vehicular ? 'selected' : '' }}>
                            {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Campo de equipo, placa, marca y asignado. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" class="form-control read-only" value="{{ old('equipo', $registro->equipo) }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" class="form-control read-only" value="{{ old('placa', $registro->placa) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" class="form-control read-only" value="{{ old('marca', $registro->marca) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" class="form-control read-only" value="{{ old('asignado', $registro->asignado) }}" readonly>
            </div>
        </div>
        <!-- Campo de registro de combustible. -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="combustibleSelect">Registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control @error('id_registro_combustible') is-invalid @enderror" required>
                    <option value="">Seleccione un registro de combustible</option>
                    @foreach($combustibles as $combustible)
                    <option value="{{ $combustible->id }}" 
                        data-fecha="{{ $combustible->fecha }}" 
                        data-numfac="{{ $combustible->num_factura }}" 
                        data-precio="{{ $combustible->precio }}"
                        data-consumo="{{ $combustible->entradas > 0 ? $combustible->entradas : $combustible->salidas }}"
                        {{ $combustible->id == $registro->id_registro_combustible ? 'selected' : '' }}>
                        {{ $combustible->num_factura }}
                    </option>
                    @endforeach
                </select>
                @error('id_registro_combustible')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Campos de fecha, número de factura, consumo, precio y total. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="numfac">N° de Factura:</label>
                <input type="number" id="numfac" class="form-control read-only" value="{{ old('numfac', $registro->numfac) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="consumo">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" value="{{ old('consumo', $registro->consumo) }}" readonly step="0.01">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" value="{{ old('precio', $registro->precio) }}" readonly step="0.01">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="total">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" value="{{ old('total', $registro->total) }}" readonly step="0.01">
            </div>
            <!-- Campo de empresa. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control @error('empresa') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa" {{ old('empresa', $registro->empresa) == 'Taosa' ? 'selected' : '' }}>TAOSA</option>
                    <option value="Clasificadora" {{ old('empresa', $registro->empresa) == 'Clasificadora' ? 'selected' : '' }}>Clasificadora</option>
                    <option value="Francisco Gusman" {{ old('empresa', $registro->empresa) == 'Francisco Gusman' ? 'selected' : '' }}>Francisco Gusman</option>
                </select>
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Campo de tipo (Costo o Gasto). -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control editable @error('cog') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Costo" {{ old('cog', $registro->cog) && strtolower(old('cog', $registro->cog)) == 'costo' ? 'selected' : '' }}>Costo</option>
                    <option value="Gasto" {{ old('cog', $registro->cog) && strtolower(old('cog', $registro->cog)) == 'gasto' ? 'selected' : '' }}>Gasto</option>
                </select>
                @error('cog')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Botones alineados a la derecha en la misma fila que el último campo -->
            <div class="col-md-8 mb-3 d-flex justify-content-end align-items-end">
                <div class="d-flex gap-3">
                    <a href="{{ route('registroimporte.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
        <!-- Campos ocultos -->
        <input type="hidden" name="equipo" value="{{ old('equipo', $registro->equipo) }}">
        <input type="hidden" name="placa" value="{{ old('placa', $registro->placa) }}">
        <input type="hidden" name="marca" value="{{ old('marca', $registro->marca) }}">
        <input type="hidden" name="asignado" value="{{ old('asignado', $registro->asignado) }}">
        <input type="hidden" name="numfac" value="{{ old('numfac', $registro->numfac) }}">
        <input type="hidden" name="consumo" value="{{ old('consumo', $registro->consumo) }}">
        <input type="hidden" name="precio" value="{{ old('precio', $registro->precio) }}">
        <input type="hidden" name="total" value="{{ old('total', $registro->total) }}">
    </form>
</div>

<script>
    // Script para actualizar los datos del vehículo y combustible al cambiar las selecciones.
    document.addEventListener("DOMContentLoaded", function () {
        let vehiculoSelect = document.getElementById('vehiculoSelect');
        let combustibleSelect = document.getElementById('combustibleSelect');
        // Función para actualizar los datos del vehículo.
        function actualizarDatosVehiculo() {
            let selectedOption = vehiculoSelect.options[vehiculoSelect.selectedIndex];
            if (selectedOption) {
                document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo') || '';
                document.getElementById('placa').value = selectedOption.getAttribute('data-placa') || '';
                document.getElementById('marca').value = selectedOption.getAttribute('data-marca') || '';
                document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado') || '';
            }
        }
        // Función para actualizar los datos del combustible.
        function actualizarDatosCombustible() {
            let selectedOption = combustibleSelect.options[combustibleSelect.selectedIndex];
            if (selectedOption) {
                let fecha = selectedOption.getAttribute('data-fecha') || '';  
                let numFac = selectedOption.getAttribute('data-numfac') || '';
                let precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
                let consumo = parseFloat(selectedOption.getAttribute('data-consumo')) || 0;
                
                // Calcular el total.
                let total = consumo * precio;
                // Actualizar los campos del formulario.
                document.getElementById('fecha').value = fecha;
                document.getElementById('numfac').value = numFac;
                document.getElementById('consumo').value = consumo.toFixed(2);
                document.getElementById('precio').value = precio.toFixed(2);
                document.getElementById('total').value = total.toFixed(2);
            } else {
                // Si no se selecciona ninguna opción, limpiar los campos relacionados.
                console.log("⚠ No se encontró ninguna opción seleccionada en el select de combustible.");
            }
        }
        // Asignar los eventos de cambio a los selects.
        vehiculoSelect.addEventListener('change', actualizarDatosVehiculo);
        combustibleSelect.addEventListener('change', actualizarDatosCombustible);

        // Inicializar los datos cuando la página carga.
        if (vehiculoSelect.value) {
            actualizarDatosVehiculo();
        }
        if (combustibleSelect.value) {
            actualizarDatosCombustible();
        }
    });
</script>
<script>
    // Script para habilitar o deshabilitar el botón de actualización según los cambios en el formulario.
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("update-form");
        const submitButton = document.querySelector("button[type='submit']");

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
    });
</script>

@endsection
