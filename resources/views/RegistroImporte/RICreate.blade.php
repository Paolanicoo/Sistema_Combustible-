@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}}

@section('titulo','Crear registro combustible') {{-- Define el título que se usará en la vista --}}

@section('contenido') {{-- Inicia la sección de contenido principal --}}

<style>
     /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /* Define la fuente principal del sitio como 'Poppins'. */
        background-color: #f8f9fa; /* Establece un color de fondo gris claro para la página. */
        color: #000; /* Define el color del texto como negro. */
        font-size: 15px; /* Establece el tamaño base del texto en 15 píxeles. */
    }

    .card {
        border-radius: 12px; /* Aplica bordes redondeados de 12 píxeles. */
        border: none; /* Elimina cualquier borde predeterminado. */ 
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Agrega una sombra suave alrededor de la tarjeta. */
        overflow: hidden; /* Oculta cualquier contenido que sobresalga del borde de la tarjeta. */
        margin: 50px auto; /* Aplica un margen vertical de 50px y centra horizontalmente. */
        max-width: 900px; /* Limita el ancho máximo de la tarjeta a 900 píxeles. */
    }

    .card-header {
        background-color: #fff; /* Establece el fondo del encabezado de la tarjeta en blanco. */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Agrega una línea sutil en la parte inferior del encabezado. */
        padding: 1rem 1.5rem; /* Aplica espaciado interno (padding) de 1rem arriba/abajo y 1.5rem a los lados. */
        display: flex; /* Usa Flexbox para alinear los elementos del encabezado. */
        justify-content: center; /* Centra horizontalmente el contenido del encabezado. */
        align-items: center; /* Centra verticalmente el contenido del encabezado. */
    }

    .centered-title {
        color: #344767; /* Aplica un color azul oscuro al título. */
        font-weight: 530; /* Define el grosor de la fuente ligeramente superior al normal. */
        margin-bottom: 0; /* Elimina el margen inferior del título. */
        text-align: center; /* Centra el texto del título horizontalmente. */
    }

    .card-body {
        padding: 1.5rem; /* Agrega 1.5rem de espaciado interno en todo el cuerpo de la tarjeta. */
        background-color: #fff; /* Establece el fondo del cuerpo de la tarjeta en blanco. */
    }

    .form-label {
        display: block; /* Hace que la etiqueta del formulario ocupe toda la línea. */
        margin-bottom: 6px; /* Agrega 6 píxeles de espacio debajo de la etiqueta. */
        font-weight: 600; /* Aplica un grosor de fuente semi-negrita. */
        color: #344767; /* Usa un color azul oscuro para el texto de la etiqueta. */
        font-size: 1rem !important; /* Establece el tamaño de fuente en 1rem con prioridad. */
        letter-spacing: 0.3px; /* Aumenta ligeramente el espacio entre letras. */
    }

    .form-control {
        width: 100%; /* El campo ocupa todo el ancho disponible. */
        padding: 10px 12px; /* Añade espacio interno de 10px vertical y 12px horizontal. */
        border: 1px solid #e2e8f0; /* Borde gris claro. */
        border-radius: 8px; /* Bordes redondeados de 8 píxeles. */
        font-size: 0.9375rem; /* Tamaño de fuente ligeramente menor a 1rem. */
        transition: all 0.3s ease; /* Transición suave para cambios de estilo. */
        color: #344767; /* Color del texto azul oscuro. */
        background-color: #fff; /* Fondo blanco. */
    }


    .form-control:focus {
        border-color: #0ea5e9; /* Borde azul claro al enfocar. */
        outline: none; /* Elimina el contorno predeterminado del navegador. */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Sombra azul clara alrededor del campo enfocado. */
    }

    .form-control.is-invalid {
        border-color: #dc3545; /* Borde rojo para campos inválidos. */
    }

    .form-control[readonly] {
        background-color: #f1f1f1 !important; /* Fondo gris claro para campos de solo lectura. */
        color: #6c757d !important; /* Texto gris oscuro. */
        cursor: not-allowed; /* Cambia el cursor para indicar que no se puede editar. */
    }

    .text-danger, .invalid-feedback {
        color: #dc3545; /* Texto rojo para mensajes de error. */
        font-size: 0.8125rem; /* Tamaño de fuente más pequeño. */
        margin-top: 4px; /* Espacio arriba del texto. */
        display: block; /* Ocupa toda la línea. */
    }

    .btn {
        padding: 0.5rem 1rem; /* Espaciado interno: 0.5rem vertical y 1rem horizontal. */
        border-radius: 8px; /* Bordes redondeados. */
        font-weight: 600; /* Texto en semi-negrita. */
        font-size: 0.9rem; /* Tamaño del texto. */
        transition: all 0.3s ease; /* Transición suave al cambiar estilos. */
        display: flex; /* Usa Flexbox para alinear contenido interno. */
        align-items: center; /* Centra verticalmente el contenido. */
        justify-content: center; /* Centra horizontalmente el contenido. */
        gap: 8px; /* Espacio entre íconos y texto dentro del botón. */
    }

    .btn-secondary {
        background-color: #f1f5f9; /* Fondo gris muy claro. */
        color: #344767; /* Texto azul oscuro. */
        border: none; /* Sin borde. */
    }

    .btn-secondary:hover {
        background-color: #e2e8f0; /* Cambia el fondo al pasar el mouse. */
        transform: translateY(-2px); /* Eleva ligeramente el botón al hacer hover. */
    }

    .btn-custom {
        background-color: #0ea5e9; /* Fondo azul. */
        border-color: #0ea5e9; /* Mismo color en el borde. */
        color: #000; /* Letra negra por defeco */
    }

    .btn-custom:hover,
    .btn-custom:active,
    .btn-custom:focus {
        background-color: #0284c7; /* Azul más oscuro al interactuar. */
        border-color: #0284c7; /* Borde azul oscuro. */
        color: #ffffff; /* Letra blanca al presionar o pasar el mouse */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra azul suave. */
        transform: translateY(-2px); /* Efecto de elevación. */
    }

    textarea.form-control {
        height: 80px; /* Altura fija de 80 píxeles. */
        resize: vertical; /* Solo permite redimensionar verticalmente. */
    }

    .action-buttons {
        display: flex; /* Usa Flexbox para organizar botones. */
        gap: 8px; /* Espacio entre botones. */
        justify-content: flex-end; /* Alinea los botones al final (derecha). */
    }

    .btn-icon {
        width: 40px; /* Ancho fijo de 40 píxeles. */
        height: 40px; /* Alto fijo de 40 píxeles. */
        padding: 0; /* Sin relleno interno. */
        display: flex; /* Usa Flexbox para centrar contenido. */
        align-items: center; /* Centra verticalmente. */
        justify-content: center; /* Centra horizontalmente. */
        border-radius: 8px; /* Bordes redondeados. */
    }

    .encabezado-seccion {
        background-color: #f0f0f0;  /* Fondo gris claro. */
        color: #344767; /* Texto azul oscuro. */
        padding: 15px; /* Espaciado interno uniforme. */
        border-radius: 8px; /* Bordes redondeados. */
        text-align: center; /* Centra el texto. */
        margin-bottom: 20px; /* Espacio debajo del encabezado. */
    }

    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;  /* El grupo ocupa todo el ancho disponible en pantallas pequeñas. */
        }

        .form-label {
            font-size: 0.9375rem !important; /* Reduce el tamaño de las etiquetas en pantallas pequeñas. */
        }
    }
</style>

<!--Encabezado de la pagina.-->
<div class="card p-4">
    <form method="post" action="{{ route('registroimporte.store') }}" id="create-form">
        @csrf
        <div class="encabezado-seccion">
            <h3 class="m-0">Resumen importe</h3>
        </div>
        <div class="mb-4"></div>
        <!-- Campo de Fecha. -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control read-only" readonly required>
            </div>
            <!-- Campo de Vehículo. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}" 
                            data-equipo="{{ $vehiculo->equipo }}" 
                            data-placa="{{ $vehiculo->placa }} "
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}">
                            {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Campo de Equipo. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control read-only" readonly>
            </div>
        </div>
        <!-- Campo de Placa. -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control read-only" readonly>
            </div>
            <!-- Campo de Marca. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control read-only" readonly>
            </div>
            <!-- Campo de Asignado. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control read-only" readonly>
            </div>
        </div>
        <!-- Campo de Registro de combustible. -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="combustibleSelect">Registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control @error('id_registro_combustible') is-invalid @enderror" required>
                    <option value="">Seleccione un registro de combustible</option>
                    @if(isset($combustibles) && $combustibles->count() > 0)
                        @foreach($combustibles as $combustible)
                            <option value="{{ $combustible->id }}" 
                                data-fecha="{{ $combustible->fecha }}" 
                                data-numfac="{{ $combustible->num_factura }}" 
                                data-precio="{{ $combustible->precio }} "
                                data-consumo="{{ $combustible->entradas > 0 ? $combustible->entradas : $combustible->salidas }} ">
                                {{ $combustible->num_factura }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('id_registro_combustible')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Campo de N° de Factura. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="numfac">N° de Factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control read-only" readonly>
            </div>
            @error('number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <!-- Campo de Consumo. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="consumo">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" readonly step="0.01">
            </div>
            @error('consumo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <!-- Campo de Precio. -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" readonly step="0.01">
            </div>
            @error('precio')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <!-- Campo de Total. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="total">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" readonly step="0.01">
            </div>
            @error('total')
                    <span class="text-danger">{{ $message }}</span>
            @enderror
            <!-- Campo de Empresa. -->
            <div class="col-md-4 mb-3">
                <label class="form-label" for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control @error('empresa') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa">TAOSA</option>
                    <option value="Clasificadora">Clasificadora</option>
                    <option value="Francisco Gusman">Francisco Gusman</option>
                </select>
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Campo de Tipo. -->
        <div class="row">
            <div class="col-md-4 mb-3">
            <label class="form-label" for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control @error('cog') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="costo">Costo</option>
                    <option value="gasto">Gasto</option>
                </select>
                @error('cog')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Botones alineados a la derecha en la misma fila que el último campo. -->
            <div class="col-md-8 mb-3 d-flex justify-content-end align-items-end">
                <div class="d-flex gap-3">
                    <a href="{{ route('registroimporte.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Cuando se seleccione un vehículo, llena los campos relacionados.
    document.getElementById('vehiculoSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        // Actualiza los campos del formulario con los valores seleccionados.
        // Verifica si hay un valor seleccionado.
        if (!selectedOption.value) {
            document.getElementById('equipo').value = '';
            document.getElementById('placa').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('asignado').value = '';
            return; // Sale de la función si no hay opción seleccionada.
        }
        // Asigna los valores de los atributos data a los campos del formulario.
        document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
        document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
        document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
        document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
    });

    // Cuando se seleccione un combustible, llena los campos relacionados.
    document.getElementById('combustibleSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];

        let fecha = selectedOption.getAttribute('data-fecha') || '';
        let numFactura = selectedOption.getAttribute('data-numfac') || '';
        let consumo = parseFloat(selectedOption.getAttribute('data-consumo')) || 0;
        let precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
        let total = consumo * precio;
        // Actualiza los campos del formulario con los valores seleccionados.
        document.getElementById('fecha').value = fecha;
        document.getElementById('numfac').value = numFactura;
        document.getElementById('consumo').value = consumo;
        document.getElementById('precio').value = precio;
        document.getElementById('total').value = total.toFixed(2);
    });

    // Asegurarse de que el formulario se envíe correctamente.
    document.getElementById('create-form').addEventListener('submit', function(event) {
        // Validar que los campos requeridos estén completos antes de enviar.
        let vehiculo = document.getElementById('vehiculoSelect').value;
        let combustible = document.getElementById('combustibleSelect').value;
        let empresa = document.getElementById('empresa').value;
        let cog = document.getElementById('cog').value;
        // Si alguno de los campos requeridos está vacío, prevenir el envío del formulario.
        if (!vehiculo || !combustible || !empresa || !cog) {
            event.preventDefault();
            alert('Por favor complete todos los campos requeridos');
        }
    });
</script>
@endsection

