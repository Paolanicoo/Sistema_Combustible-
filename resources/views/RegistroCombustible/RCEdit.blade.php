@extends('Layouts.app')

@section('titulo','Editar Registro de Combustible')

@section('contenido')

<style>  
    /* Estilos base */
    body { /* Estilo para el cuerpo del documento. */
        font-family: 'Poppins', sans-serif; /* Fuente personalizada. */
        background-color: #f8f9fa; /* Color de fondo gris claro. */
        color: #000; /* Color del texto negro. */
        font-size: 15px; /* Tamaño base aumentado. */
    }
    
    .card { /* Estilo para las tarjetas. */
        border-radius: 12px; /* Bordes redondeados. */
        border: none; /* Sin borde. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra suave. */
        overflow: hidden; /* Oculta el desbordamiento. */
        margin: 50px auto; /* Margen superior e inferior de 50px, centrado horizontalmente. */
        max-width: 900px; /* Ancho máximo de la tarjeta. */
    }
    
    .card-header { /* Estilo para la cabecera de la tarjeta. */
        background-color: #fff; /* Color de fondo blanco. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior suave. */
        padding: 1rem 1.5rem; /* Padding interno. */
        display: flex; /* Usar flexbox para alinear elementos. */
        justify-content: space-between; /* Espacio entre elementos. */
        align-items: center; /* Alinear verticalmente al centro. */
    }
    
    .centered-title { /* Estilo para el título centrado. */
        color: #344767; /* Color del texto. */
        font-weight: 530; /* Peso de la fuente. */
        margin-bottom: 0; /* Sin margen inferior. */
    }
    
    .card-body { /* Estilo para el cuerpo de la tarjeta. */
        padding: 1.5rem; /* Padding interno. */
        background-color: #fff; /* Color de fondo blanco. */
    }

    /* LABELS - Tamaño aumentado y más visibles. */
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600; /* Más negrita. */
        color: #344767; /* Color más oscuro. */
        font-size: 1rem !important; /* 16px - Tamaño aumentado. */
        letter-spacing: 0.3px;
    }

    /* INPUTS - Tamaño consistente. */
    .form-control { /* Estilo para los campos de entrada .*/
        width: 100%; /* Ancho completo. */
        padding: 10px 12px; /* Más espacio interno. */
        border: 1px solid #e2e8f0; /* Borde gris claro. */
        border-radius: 8px; /* Bordes redondeados. */
        font-size: 0.9375rem; /* 15px - Tamaño de la fuente. */
        transition: all 0.3s ease; /* Transición suave para todos los cambios. */
        color: #344767; /* Color del texto. */
    }
    
    .form-control:focus { /* Estilo al enfocar el campo de entrada. */
        border-color: #0ea5e9; /* Color del borde azul al enfocar. */
        outline: none; /* Sin contorno */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Sombra azul al enfocar. */
    }
    
    .form-control.is-invalid { /* Estilo para campos de entrada inválidos. */
        border-color: #dc3545; /* Color del borde rojo. */
    }
    
    .text-danger { /* Estilo para mensajes de error. */
        color: #dc3545; /* Color rojo. */
        font-size: 0.8125rem; /* 13px - Tamaño de la fuente. */
        margin-top: 4px; /* Margen superior. */
        display: block; /* Mostrar como bloque. */
    }
    
    /* Botones */
    .btn { /* Estilo para todos los botones. */
        padding: 0.5rem 1rem; /* Padding interno. */
        border-radius: 8px; /* Bordes redondeados. */
        font-weight: 600; /* Peso de la fuente. */
        font-size: 0.9rem; /* Tamaño de la fuente. */
        transition: all 0.3s ease; /* Transición suave para todos los cambios. */
        display: flex; /* Usar flexbox para alinear contenido. */
        align-items: center; /* Alinear verticalmente al centro. */
        justify-content: center; /* Centrar horizontalmente. */
        gap: 8px; /* Espacio entre elementos dentro del botón. */
    }

    .btn-secondary { /* Estilo para el botón secundario. */
        background-color: #f1f5f9; /* Color de fondo gris claro. */
        color: #344767; /* Color del texto gris oscuro. */
        border: none; /* Sin borde */
    }
    .btn-secondary:hover { /* Estilo al pasar el mouse sobre el botón secundario. */
        background-color: #e2e8f0; /* Color de fondo gris más oscuro. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
    }
    .btn-custom { /* Estilo para el botón personalizado. */
        background-color: #0ea5e9; /* Color de fondo azul. */
        border-color: #0ea5e9; /* Color del borde azul. */
        color: #344767;  /* Color del texto gris oscuro. */
    }

    .btn-custom:hover { /* Estilo al pasar el mouse sobre el botón personalizado. */
        background-color: #0284c7; /* Color de fondo azul oscuro. */
        border-color: #0284c7; /* Color del borde azul oscuro. */
        color: white;  /* Letras blancas al pasar el cursor. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
    }

    .btn-info { /* Estilo para el botón de información */
        background-color: #0ea5e9; /* Color de fondo azul. */
        border-color: #0ea5e9; /* Color del borde azul. */
        color: #344767; /* Color del texto gris oscuro. */
    }

    .btn-info:hover { /* Estilo al pasar el mouse sobre el botón de información. */
        background-color: #0284c7; /* Color de fondo azul oscuro. */
        border-color: #0284c7; /* Color del borde azul oscuro. */
        color: white; /* Color del texto blanco */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Mueve el botón ligeramente hacia arriba. */
    }

    /* NUEVO: Estilo para cuando el botón está deshabilitado. */
    .btn-info:disabled, /* Estilo para el botón de información deshabilitado. */
    .btn-info[disabled] { /* Estilo para el botón de información deshabilitado (otra forma). */
        background-color: #0ea5e9 !important; /* Color de fondo azul. */
        border-color: #0ea5e9 !important; /* Color del borde azul. */
        color: #344767 !important; /* Color del texto gris oscuro. */
        opacity: 1 !important; /* Asegura que no se vea opaco. */
        cursor: not-allowed; /* Cambia el cursor a no permitido. */
        box-shadow: none; /* Sin sombra. */
        transform: none; /* Sin transformación. */
    }
    
    textarea.form-control { /* Estilo para los campos de texto. */
        height: 80px; /* Altura del campo de texto. */
        resize: vertical; /* Permitir redimensionar verticalmente. */
    }
    
    /* Botones de acción. */
    .action-buttons { /* Estilo para el contenedor de botones de acción. */
        display: flex; /* Usar flexbox. */
        gap: 8px; /* Espacio entre botones. */
    }
    
    .btn-icon { /* Estilo para botones con icono. */
        width: 40px; /* Ancho del botón. */
        height: 40px; /* Alto del botón. */
        padding: 0; /* Sin padding. */
        display: flex; /* Usar flexbox. */
        align-items: center; /* Alinear verticalmente al centro. */
        justify-content: center; /* Centrar horizontalmente. */
        border-radius: 8px; /* Bordes redondeados. */
    }
    
    @media (max-width: 768px) { /* Estilos para pantallas pequeñas. */
        .form-group { /* Estilo para grupos de formulario. */
            flex: 1 1 100%; /* Ocupa el 100% del ancho. */
        }
        
        /* Ajustes para móviles. */
        .form-label { /* Estilo para etiquetas de formulario en móviles. */
            font-size: 0.9375rem !important; /* 15px en móviles. */
        }
    }
    .form-control.is-invalid { /* Estilo para campos de entrada inválidos. */
        border-color: #dc3545; /* Color del borde rojo. */
    }
    .text-danger { /* Estilo para mensajes de error. */
        color: #dc3545; /* Color rojo. */
        font-size: 0.75rem; /* Tamaño de la fuente reducido. */
        margin-top: 3px; /* Margen superior. */
        display: block; /* Mostrar como bloque. */
    } 

    .encabezado-seccion { /* Estilo para el encabezado de sección. */
        background-color: #f0f0f0; /* Color de fondo gris claro. */
        color: #344767; /* Color del texto gris oscuro. */
        padding: 15px; /* Padding interno. */
        border-radius: 8px; /* Bordes redondeados. */
        text-align: center; /* Centrar texto. */
        margin-bottom: 20px; /* Margen inferior. */
        width: 100%;  /* Asegura que el fondo ocupe todo el ancho. */
    }
    .form-control[readonly] { /* Estilo para campos de entrada de solo lectura. */
        background-color: #f0f0f0; /* Color de fondo gris claro. */
        color: #344767; /* Color del texto gris oscuro. */
        cursor: not-allowed; /* Cambia el cursor a no permitido. */
    }
    
</style>

<div class="card p-4"> <!-- Contenedor principal de la tarjeta con padding. -->
    <form id="vehicle-form" method="post" action="{{ route('registrocombustible.update', $registro->id) }}"> <!-- Formulario para editar el registro de combustible. -->
        @csrf <!-- Token de seguridad para proteger el formulario. -->
        @method('PUT') <!-- Método PUT para la actualización del registro. -->
        <div class="encabezado-seccion mb-4"> <!-- Encabezado de la sección con margen inferior. -->
            <h3 class="m-0">Editar registro de combustible</h3> <!-- Título de la sección. -->
        </div>

        <!-- Fila 1 (3 campos fecha, vehiculo, número de factura.) -->
        <div class="row mb-3"> <!-- Fila de Bootstrap con margen inferior. -->
            <div class="col-md-4"> <!-- Columna de Bootstrap para el campo de fecha. -->
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ $registro->fecha }}" required >
                @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-4"> <!-- Columna de Bootstrap para el campo de vehículo. -->
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo) <!-- Iterar sobre la lista de vehículos. -->
                        <option value="{{ $vehiculo->id }}" 
                            data-equipo="{{ $vehiculo->equipo }}" 
                            data-placa="{{ $vehiculo->placa }}" 
                            data-marca="{{ $vehiculo->marca }}" 
                            data-asignado="{{ $vehiculo->asignado }}" 
                            {{ $vehiculo->id == $registro->id_registro_vehicular ? 'selected' : '' }}> <!-- Opción del vehículo, seleccionada si coincide. -->
                            {{ $vehiculo->equipo }} - {{ $vehiculo->placa }} <!-- Texto mostrado en la opción. -->
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>

            <div class="col-md-4"> <!-- Columna de Bootstrap para el campo de número de factura. -->
                <label class="form-label" for="num_factura">No. Factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control @error('num_factura') is-invalid @enderror" value="{{ $registro->num_factura }}" required oninput="validarNumeroEntero(this)">
                @error('num_factura') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Fila 2 (Datos del vehículo - 4 campos.) -->
        <div class="row mb-3">
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de equipo. -->
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" value="{{ $registro->equipo }}" readonly> <!-- Campo de entrada para el equipo, solo lectura. -->
                @error('equipo') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de placa. -->
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" value="{{ $registro->placa }}" readonly> <!-- Campo de entrada para la placa, solo lectura. -->
                @error('placa') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de marca. -->
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="{{ $registro->marca }}" readonly> <!-- Campo de entrada para la marca, solo lectura. -->
                @error('marca') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de asignado. -->
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" value="{{ $registro->asignado }}" readonly> <!-- Campo de entrada para el asignado, solo lectura. -->
                @error('asignado') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Fila 3 (4 campos.) -->
        <div class="row mb-3">
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de tipo de medida. -->
                <label class="form-label" for="tipo">Tipo de Medida:</label>
                <select id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror" required> <!-- Campo de selección para tipo de medida. -->
                <option value="galones" {{ old('tipo', $registro->tipo) === 'galones' ? 'selected' : '' }}>Galones</option>
                <option value="litros" {{ old('tipo', $registro->tipo) === 'litros' ? 'selected' : '' }}>Litros</option>
                </select>
                
                @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de entradas. -->
                <label class="form-label" for="entradas">Entrada:</label>
                <input type="text" id="entradas" name="entradas" class="form-control" value="{{ old('entradas', $registro->entradas) }}" oninput="validarNumeroDecimal(this)"> <!-- Campo para entradas. -->

                @error('entradas') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de salidas. -->
                <label class="form-label" for="salidas">Salida:</label>
                <input type="text" id="salidas" name="salidas" class="form-control" value="{{ $registro->salidas }}" oninput="validarNumeroDecimal(this)"> <!-- Campo para salidas. -->
                @error('salidas') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3"> <!-- Columna de Bootstrap para el campo de precio por galón. -->
                <label class="form-label" for="precio">Precio por Galón:</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ $registro->precio }}" required oninput="validarNumeroDecimal(this)"><!-- Campo de entrada para precio por galón -->
                @error('precio') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Fila 4 (Solo observación.) -->
        <div class="row mb-3">
            <div class="col-12"> <!-- Columna de Bootstrap que ocupa todo el ancho. -->
                <label class="form-label" for="observacion">Observaciones:</label>
                <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="60">{{ $registro->observacion }}</textarea> <!-- Campo de texto para observaciones -->
                @error('observacion') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-3 mt-4"> <!-- Contenedor flexible para los botones, alineado a la derecha. -->
            <a href="{{ route('registrocombustible.index') }}" class="btn btn-secondary"> <!-- Botón para regresar a la lista de registros. -->
                <i class="fas fa-arrow-left"></i> Regresar <!-- Icono y texto del botón. -->
            </a>
            <button type="submit" class="btn btn-info"> <!-- Botón para enviar el formulario. -->
                <i class="fas fa-sync-alt"></i> Actualizar <!-- Icono y texto del botón. -->
            </button>
        </div>
    </form>
</div>

<script>
   function validarNumeroDecimal(input) { //Función para validar que el input sea un número decimal.
    let value = input.value.replace(/[^0-9.]/g, ''); // Elimina caracteres no válidos.
    let parts = value.split('.');// Divide el número por el punto decimal.
     // Si hay más de un punto, conserva la parte antes del primer punto y los primeros 3 dígitos después del punto.
    if (parts.length > 1) {
        value = parts[0] + '.' + parts[1].slice(0, 2); // Limita a 3 dígitos después del punto.
    }
    input.value = value; // Asigna el valor validado al input.
}

let valorOriginalEntradas = null; // Variable para almacenar el valor original de entradas.

function convertirEntradas() { //Función para convertir entradas de litros a galones .
    const tipo = document.getElementById('tipo').value; // Obtiene el tipo de medida seleccionado.
    const entradasInput = document.getElementById('entradas'); // Obtiene el campo de entradas.

    if (valorOriginalEntradas === null) { // Si no se ha guardado el valor original.
        valorOriginalEntradas = parseFloat(entradasInput.value) || 0; // Guarda el valor original.
    }

    let convertido; // Variable para almacenar el valor convertido.
    if (tipo === 'litros') { // Si el tipo es litros.
        convertido = valorOriginalEntradas * 3.78541; // Convierte litros a galones.
    } else {
        convertido = valorOriginalEntradas; // Mantiene el valor original si es galones.
    }

    entradasInput.value = convertido.toFixed(2); // Asigna el valor convertido al campo de entradas.
}

document.getElementById('tipo').addEventListener('change', () => { //Evento para cuando se cambia el tipo de medida.
    // Reset para permitir reconversión desde el valor original
    valorOriginalEntradas = parseFloat(document.getElementById('entradas').value) || 0; // Guarda el valor actual.
    convertirEntradas(); // Convierte las entradaS.
});


    document.addEventListener("DOMContentLoaded", function() {
        let vehiculoSelect = document.getElementById('vehiculoSelect'); // Obtiene el campo de selección de vehículo.

        function actualizarDatosVehiculo() { //Función para actualizar los datos del vehículo.
            var selectedOption = vehiculoSelect.options[vehiculoSelect.selectedIndex]; // Obtiene la opción seleccionada.

            document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo') || '';
            document.getElementById('placa').value = selectedOption.getAttribute('data-placa') || '';
            document.getElementById('marca').value = selectedOption.getAttribute('data-marca') || '';
            document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado') || '';
        }

        // Evento para cuando se cambia de vehículo.
        vehiculoSelect.addEventListener('change', actualizarDatosVehiculo);

        // Llenar los datos al cargar la página.
        actualizarDatosVehiculo();
    });

    document.addEventListener("DOMContentLoaded", function() {
        let precioInput = document.getElementById('precio'); // Obtiene el campo de precio.
        let salidasInput = document.getElementById('salidas'); // Obtiene el campo de salidas.
        let totalInput = document.getElementById('total'); // Obtiene el campo de total.

        // Añadir validación de entrada para precio y salidas.
        precioInput.addEventListener('input', function() {
            validarNumeroDecimal(this);
        });

        salidasInput.addEventListener('input', function() { // Obtiene el campo de total.
            validarNumeroDecimal(this); // Llama a la función de validación.
        });

        function calcularTotal() { //Función para calcular el total.
            let precio = parseFloat(precioInput.value) || 0; // Obtiene el precio.
            let salidas = parseFloat(salidasInput.value) || 0; // Obtiene las salidas.

            let total = precio * salidas; // Calcula el total.
            
            // Solo establecer total si existe el input.
            if (totalInput) {
                totalInput.value = total.toFixed(2);
            }
        }

        // Eventos para calcular el total automáticamente.
        precioInput.addEventListener('input', calcularTotal);
        salidasInput.addEventListener('input', calcularTotal);

        // Calcular el total al cargar la página si ya hay valores.
        calcularTotal();
    });

   
    // Deshabilitar de actualizar.
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("vehicle-form");
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
