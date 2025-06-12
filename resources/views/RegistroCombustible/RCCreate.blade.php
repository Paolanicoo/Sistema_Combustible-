@extends('Layouts.app')

@section('titulo','creacion de registro Combustible')

@section('contenido')

<style>
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /* Fuente utilizada para el cuerpo. */
        background-color: #f8f9fa; /* Color de fondo. */
        color: #000; /* Color del texto .*/
        font-size: 15px; /* Tamaño base aumentado */
    }

    .card {
        border-radius: 12px; /* Bordes redondeados. */
        border: none; /* Sin borde. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra. */
        overflow: hidden; /* Oculta el desbordamiento. */
        margin: 50px auto; /* Margen superior e inferior, centrado horizontalmente. */
        max-width: 900px; /* Ancho máximo de la tarjeta. */
    }
     /* Encabezado de la tarjeta con color blanco y borde inferior suave.*/
    .card-header {
        background-color: #fff;/* Color de fondo del encabezado. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior. */
        padding: 1rem 1.5rem; /* Espaciado interno. */
        display: flex; /* Flexbox para centrar contenido. */
        justify-content: center; /* Centra horizontalmente. */
        align-items: center; /* Centra verticalmente. */
    }
     /*Título centrado con color y grosor medio.*/
    .centered-title {
        color: #344767; /* Color del título. */
        font-weight: 530; /* Grosor de la fuente. */
        margin-bottom: 0; /* Sin margen inferior. */
        text-align: center; /* Centra el texto. */
    }
     /* Cuerpo de la tarjeta con fondo blanco y espacio interno.*/
    .card-body {
        padding: 1.5rem; /* Espaciado interno. */
        background-color: #fff; /* Color de fondo. */
    }

    /* LABELS - Tamaño aumentado y más visibles. */
    .form-label {
        display: block; /* Muestra como bloque. */
        margin-bottom: 6px; /* Margen inferior. */
        font-weight: 600; /* Más negrita. */
        color: #344767; /* Color más oscuro. */
        font-size: 1rem !important; /* 16px - Tamaño aumentado. */
        letter-spacing: 0.3px; /* Espaciado entre letras. */
    }

    /* INPUTS - Tamaño consistente. */
    .form-control {
        width: 100%; /* Ancho completo. */
        padding: 10px 12px; /* Más espacio interno */
        border: 1px solid #e2e8f0; /* Borde. */
        border-radius: 8px; /* Bordes redondeados. */
        font-size: 0.9375rem; /* Tamaño de fuente. */
        transition: all 0.3s ease; /* Transición suave. */
        color: #344767; /* Color del texto .*/
    }
     /*Efecto de enfoque azul al seleccionar un campo.*/
    .form-control:focus {
        border-color: #0ea5e9; /* Color del borde al enfocar. */
        outline: none; /* Sin contorno */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Sombra al enfocar. */
    }
     /* Bordes rojos en campos inválidos.*/
    .form-control.is-invalid {
        border-color: #dc3545; /* Color del borde en error. */
    }
     /* Texto de error en rojo debajo del campo.*/
    .text-danger {
        color: #dc3545;/* Color del texto de error. */
        font-size: 0.8125rem; /* Tamaño de fuente. */
        margin-top: 4px;/* Margen superior. */
        display: block; /* Muestra como bloque. */
    }

    /* Botones */
    .btn {
        padding: 0.5rem 1rem; /* Espaciado interno. */
        border-radius: 8px; /* Bordes redondeados. */
        font-weight: 600; /* Grosor de la fuente. */
        font-size: 0.9rem; /* Tamaño de fuente. */
        transition: all 0.3s ease; /* Transición suave. */
        display: flex; /* Flexbox para alinear contenido. */
        align-items: center; /* Centra verticalmente. */
        justify-content: center; /* Centra horizontalmente. */
        gap: 8px; /* Espacio entre íconos y texto. */
    }
    /*Botón gris claro para acciones secundarias.*/
    .btn-secondary {
        background-color: #f1f5f9; /* Color de fondo. */
        color: #344767; /* Color del texto. */
        border: none; /* Sin borde. */
    }
    /*Al pasar el mouse, se aclara y se eleva un poco.*/
    .btn-secondary:hover {
        background-color: #e2e8f0; /* Color de fondo al pasar el mouse. */
        transform: translateY(-2px); /* Eleva el botón. */
    }
    /* Botón azul personalizado para guardar.*/
    .btn-custom {
        background-color: #0ea5e9;/* Color de fondo. */
        border-color: #0ea5e9;/* Color del borde. */
        color: #344767;  /* Color del texto. */
    }
    /*Efecto al pasar el mouse sobre el botón personalizado.*/
    .btn-custom:hover {
        background-color: #0284c7; /* Color de fondo al pasar el mouse. */
        border-color: #0284c7; /* Color del borde al pasar el mouse. */
        color: white;  /* Letras blancas al pasar el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Eleva el botón. */
    }
    
    textarea.form-control {
        height: 80px; /* Altura del área de texto .*/
        resize: vertical; /* Permite redimensionar verticalmente. */
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;/* Flexbox para alinear botones. */
        gap: 8px; /* Espacio entre botones. */
        justify-content: flex-end; /* Alinea los botones a la derecha. */
    }

    .btn-icon {
        width: 40px; /* Ancho del botón */
        height: 40px; /* Altura del botón */
        padding: 0; /* Sin espaciado interno */
        display: flex; /* Flexbox para centrar íconos */
        align-items: center; /* Centra verticalmente */
        justify-content: center; /* Centra horizontalmente */
        border-radius: 8px; /* Bordes redondeados */
    }
     
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }

        /* Ajustes para móviles */
        .form-label {
            font-size: 0.9375rem !important; /* 15px en móviles */
        }
    }

    .form-control.is-invalid {
        border-color: #dc3545;/* Color del borde en error. */
    }

    .text-danger {
        color: #dc3545; /* Color del texto de error. */
        font-size: 0.75rem; /* Tamaño de fuente. */
        margin-top: 3px; /* Margen superior */
        display: block; /* Muestra como bloque */
    }

    .encabezado-seccion {
        background-color: #f0f0f0; /* Color de fondo. */
        color: #344767; /* Color de fondo. */
        padding: 15px; /* Espaciado interno. */
        border-radius: 8px; /* Bordes redondeados. */
        text-align: center; /* Centra el texto. */
        margin-bottom: 20px; /* Margen inferior. */
    }
     /*Campos de solo lectura con fondo gris y texto gris. */
    .form-control[readonly] {
        background-color: #f0f0f0; /* Color de fondo */
        color: #344767; /* mismo color del texto del título. */
        cursor: not-allowed; /* opcional, para mostrar que no se puede editar .*/
    }

</style>

<div class="card p-4">
    <form method="post" action="{{ route('registrocombustible.store') }}">  <!--Formulario con método POST hacia la ruta de guardar. -->
        @csrf <!-- Token de seguridad CSRF obligatorio -->
        <div class="encabezado-seccion mb-4"> <!-- Encabezado de la sección. -->
            <h3 class="m-0">Registro de combustible</h3> <!-- Título de la sección. -->
        </div>

        <!-- Fila 1 (3 campos) -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror"> <!-- Campo de fecha. -->
                @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>

            <div class="col-md-4">
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror"><!-- Selección de vehículo -->
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}"
                            data-equipo="{{ $vehiculo->equipo }}"
                            data-placa="{{ $vehiculo->placa }}"
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}">
                            {{ $vehiculo->equipo }} - {{ $vehiculo->placa }}
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>

            <div class="col-md-4">
                <label class="form-label" for="num_factura">No. Factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control @error('num_factura') is-invalid @enderror" oninput="validarNumeroEntero(this)"> <!-- Campo de número de factura -->
                @error('num_factura') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Fila 2 (Datos del vehículo - 4 campos rellenados automáticamente.) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Equipo:</label>
                <input type="text" id="equipo" class="form-control" readonly> <!-- Campo de equipo -->
            </div>
            <div class="col-md-3">
                <label class="form-label">Placa:</label>
                <input type="text" id="placa" class="form-control" readonly> <!-- Campo de placa -->
            </div>
            <div class="col-md-3">
                <label class="form-label">Marca:</label>
                <input type="text" id="marca" class="form-control" readonly> <!-- Campo de marca -->
            </div>
            <div class="col-md-3">
                <label class="form-label">Asignado:</label>
                <input type="text" id="asignado" class="form-control" readonly> <!-- Campo de asignado -->
            </div>
        </div>

        <!-- Fila 3 (tipo de medida, entrada, salida, precio por galón.) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label" for="tipo">Tipo de medida:</label>
                <select id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror"> <!-- Selección de tipo de medida -->
                    <option value="">Seleccione medida</option>
                    <option value="galones">Galones</option>
                    <option value="litros">Litros</option>
                </select>
                @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3">
                <label class="form-label" for="entradas">Entrada:</label>
                <input type="text" id="entradas" name="entradas" class="form-control" oninput="validarNumeroDecimal(this)"> <!-- Campo de entrada -->
                @error('entradas') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3">
                <label class="form-label" for="salidas">Salida:</label>
                <input type="text" id="salidas" name="salidas" class="form-control" oninput="validarNumeroDecimal(this)"> <!-- Campo de salida. -->
                @error('salidas') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
            <div class="col-md-3">
                <label class="form-label" for="precio">Precio por Galón:</label>
                <input type="text" id="precio" name="precio" class="form-control" oninput="validarNumeroDecimal(this)"> <!-- Campo de precio por galón. -->
                @error('precio') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Fila 4 (Solo observación) -->
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label" for="observacion">Observaciones:</label>
                <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="60"></textarea> <!-- Campo de observaciones. -->
                @error('observacion') <small class="text-danger">{{ $message }}</small> @enderror <!-- Mensaje de error. -->
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-3 mt-4">
            <a href="{{ route('registrocombustible.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar <!-- Botón de regresar. -->
            </a>
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-save"></i> Guardar <!-- Botón de guardar. -->
            </button>
        </div>
    </form>
</div>



<script>
    const entradaInput = document.getElementById('entradas');
    entradaInput.addEventListener('blur', function () {
        // Al salir del input (blur), formateamos a 3 decimales si es válido.
        if (!isNaN(this.value) && this.value.trim() !== '') {
            this.value = parseFloat(this.value).toFixed(2); // Formato a 2 decimales.
        }
    });
 
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Solo permite números enteros.
    }

    function validarNumeroDecimal(input) {
        // Permite números y un solo punto.
        input.value = input.value.replace(/[^0-9.]/g, '');

        // Evita más de un punto decimal.
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, '');
        }
    }
</script>


<script>
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Elimina cualquier caracter que no sea número.
    }
</script>

<script>
    function validarNumero(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite solo números y punto decimal.
    }
</script>


<script>
    window.onload = function() {
        var today = new Date(); // Obtiene la fecha actual.
        var dd = String(today.getDate()).padStart(2, '0'); // Día
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes (enero es 0).
        var yyyy = today.getFullYear(); // Año

        today = yyyy + '-' + mm + '-' + dd; // Formato yyyy-mm-dd.

        document.getElementById('fecha').value = today; // Asigna la fecha actual al campo.
    }

    document.getElementById('vehiculoSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        
        document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
        document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
        document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
        document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
    });

    function validarCampos() {
        let entradas = document.getElementById('entradas').value;
        let salidas = document.getElementById('salidas').value;

        // Limpiar mensajes de error
        document.getElementById('errorEntradas').innerText = "";
        document.getElementById('errorSalidas').innerText = "";

        // Hacer opcional la entrada o salida, pero no ambas vacías.
        if (!entrada && !salida) {
            document.getElementById('errorEntradas').innerText = "Debe ingresar entrada o salida.";
            document.getElementById('errorSalidas').innerText = "Debe ingresar entrada o salida.";
        } else {
            calcularTotal();
        }
        entradasInput.addEventListener('keydown', function (e) {
        // Bloquea las teclas que podrían generar letras como la "e", "E", "-", "+"
        if (['e', 'E', '+', '-'].includes(e.key)) {
            e.preventDefault();
        }
    });
    }
</script>
@endsection