@extends('Layouts.app')

@section('titulo','Editar Registro de Combustible')

@section('contenido')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    .form-container {
        max-width: 800px; /* Ancho moderado para el formulario */
        margin: 30px auto; /* Subido 15px para que quede más cerca de la barra superior */
        padding: 30px; /* Espacio dentro del formulario */
        background-color: #f9f9f9; /* Fondo suave para el formulario */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
    }

    .form-title {
        text-align: center; /* Centra el título */
        font-size: 24px; /* Tamaño del título */
        margin-bottom: 20px; /* Espacio debajo del título */
        color: #333; /* Color oscuro para el título */
    }

    .row {
        display: flex; /* Usamos flexbox para el layout de las columnas */
        flex-wrap: wrap; /* Para que los campos se acomoden si el tamaño es pequeño */
        gap: 20px; /* Espacio entre las columnas */
    }

    .col-md-6 {
        flex: 1 1 48%; /* Cada columna ocupa el 48% del contenedor */
    }

    .form-group {
        margin-bottom: 15px; /* Espacio entre los campos */
    }

    .form-label {
        font-size: 16px; /* Tamaño de la etiqueta */
        margin-bottom: 10px; /* Espacio debajo de la etiqueta */
        display: block; /* Para que la etiqueta ocupe toda la línea */
        font-weight: bold; /* Negrita */
        color: black; /* Color del texto */
    }

    .form-control {
        padding: 8px; 
        margin-bottom: 10px; /* Espacio entre los campos */
        border-radius: 4px; /* Bordes redondeados */
        border: 1px solid #ccc; /* Borde gris suave */
        width: 100%; /* Asegura que los campos ocupen todo el espacio disponible */
    }

    .btn-submit {
        background-color: rgb(53, 192, 88);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        width: 100%;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: rgb(40, 160, 70); /* Verde más oscuro al pasar el mouse */
        transition: 0.3s ease-in-out;
        color: black; /* Cambia el color del texto a negro */

    }

    .text-danger {
        color: red;
        font-size: 14px;
    }

    .centered-title {
        text-align: center;
        font-weight: bold;
        margin-top: 15px;
    }

    .header {
        background-color: #333;
        color: white;
        padding: 15px 0;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }

    input[readonly], select[disabled] {
    background-color: #f0f0f0; /* Fondo gris claro */
    cursor: not-allowed; /* Cursor de no permitido */
    border: 1px solid #dcdcdc; /* Borde más suave */
    color: #000; /* Color de texto normal */
    }
    

</style>


<div class="form-container">
    <h4 class="centered-title">Editar registro de combustible</h4>

    <form method="post" action="{{ route('registrocombustible.update', $registro->id) }}" id="update-form">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ old('fecha', $registro->fecha) }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="vehiculo" class="form-label">Seleccionar vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}"
                            data-equipo="{{ $vehiculo->equipo }}"
                            data-placa="{{ $vehiculo->placa }}"
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}"
                            {{ $vehiculo->id == old('id_registro_vehicular', $registro->id_registro_vehicular) ? 'selected' : '' }}>
                            {{ $vehiculo->placa }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="equipo" class="form-label">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" readonly value="{{ old('equipo', $registro->vehiculo->equipo ?? '') }}">
            </div>

            <div class="col-md-6 form-group">
                <label for="placa" class="form-label">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" readonly value="{{ old('placa', $registro->vehiculo->placa ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" readonly value="{{ old('marca', $registro->vehiculo->marca ?? '') }}">
            </div>

            <div class="col-md-6 form-group">
                <label for="asignado" class="form-label">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" readonly value="{{ old('asignado', $registro->vehiculo->asignado ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="num_factura" class="form-label">Número de factura:</label>
                <input type="number" id="num_factura" name="num_factura" class="form-control" value="{{ old('num_factura', $registro->num_factura) }}" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="entradas" class="form-label">Entrada (galones):</label>
                <input type="number" id="entradas" name="entradas" class="form-control" value="{{ old('entradas', $registro->entradas) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="salidas" class="form-label">Salida (galones):</label>
                <input type="number" id="salidas" name="salidas" class="form-control" value="{{ old('salidas', $registro->salidas) }}">
            </div>

            <div class="col-md-6 form-group">
                <label for="precio" class="form-label">Precio por galón:</label>
                <input type="number" id="precio" name="precio" class="form-control" value="{{ old('precio', $registro->precio) }}" required>
            </div>
        </div>
        </div>

        <button type="submit" class="btn-submit">Actualizar registro</button>
    </form>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    // Capturamos el evento de envío del formulario
    document.getElementById('update-form').addEventListener('submit', function (e) {
        // Evitamos que el formulario se envíe inmediatamente
        e.preventDefault();

        // Mostramos el SweetAlert de éxito
        Swal.fire({
            title: 'Registro actualizado',
            text: 'El registro se ha actualizado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            // Si el usuario acepta, enviamos el formulario
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let vehiculoSelect = document.getElementById('vehiculoSelect');

    function actualizarDatosVehiculo() {
        let selectedOption = vehiculoSelect.options[vehiculoSelect.selectedIndex];

        document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo') || '';
        document.getElementById('placa').value = selectedOption.getAttribute('data-placa') || '';
        document.getElementById('marca').value = selectedOption.getAttribute('data-marca') || '';
        document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado') || '';
    }

    // Evento para cuando se cambia de vehículo
    vehiculoSelect.addEventListener('change', actualizarDatosVehiculo);

    // Llenar los datos al cargar la página
    actualizarDatosVehiculo();
});

document.addEventListener("DOMContentLoaded", function() {
    let precioInput = document.getElementById('precio');
    let salidasInput = document.getElementById('salidas');
    let totalInput = document.getElementById('total');

    function calcularTotal() {
        let precio = parseFloat(precioInput.value) || 0;
        let salidas = parseFloat(salidasInput.value) || 0;

        let total = precio * (salidas);
        totalInput.value = total.toFixed(2); // Redondea a 2 decimales

    
    }

    // Eventos para calcular el total automáticamente cuando el usuario cambia los valores
    precioInput.addEventListener('input', calcularTotal);
    salidasInput.addEventListener('input', calcularTotal);

    // Calcular el total al cargar la página si ya hay valores
    calcularTotal();
});
</script>

<div class="mb-3 d-flex justify-content-end">
    <a href="javascript:window.history.back();" class="btn btn-secondary px-4 w-25 d-flex align-items-center justify-content-center">

        <i class="fas fa-arrow-left me-2"></i> Regresar
    </a>
</div>

@endsection
