@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

@section('contenido')

@if ($errors->any())     {{--ESTA ES LA ALERTA DE LAS VALIDACIONES--}}


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
        color: black; /* Color gris suave */
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
    <h4 class="centered-title">Registro de combustible</h4>

    <form method="post" action="{{ route('registrocombustible.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required readonly>
                @error('fecha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
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
                            data-asignado="{{ $vehiculo->asignado }}">
                            {{ $vehiculo->placa }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="equipo" class="form-label">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" readonly>
            </div>

            <div class="col-md-6 form-group">
                <label for="placa" class="form-label">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" readonly>
            </div>

            <div class="col-md-6 form-group">
                <label for="asignado" class="form-label">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="num_factura" class="form-label">Número de factura:</label>
                <input type="number" id="num_factura" name="num_factura" class="form-control" required>
                @error('num_factura')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form-group">
                <label for="entradas" class="form-label">Entrada (galones):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" >
                @error('entradas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="salidas" class="form-label">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" >
                @error('salidas')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 form-group">
                <label for="precio" class="form-label">Precio por galón:</label>
                <input type="number" id="precio" name="precio" class="form-control" required>
                @error('precio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-submit">Guardar registro</button>
    </form>
</div>



<script>

    window.onload = function() {
        var today = new Date(); // Obtiene la fecha actual
        var dd = String(today.getDate()).padStart(2, '0'); // Día
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes (enero es 0)
        var yyyy = today.getFullYear(); // Año

        today = yyyy + '-' + mm + '-' + dd; // Formato yyyy-mm-dd

        document.getElementById('fecha').value = today; // Asigna la fecha actual al campo
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

        // Hacer opcional la entrada o salida, pero no ambas vacías
        if (!entrada && !salida) {
            document.getElementById('errorEntradas').innerText = "Debe ingresar entrada o salida.";
            document.getElementById('errorSalidas').innerText = "Debe ingresar entrada o salida.";
        } else {
            calcularTotal();
        }
    }

</script>

<div class="mb-3 d-flex justify-content-end">
    <a href="javascript:window.history.back();" class="btn btn-secondary px-4 w-25 d-flex align-items-center justify-content-center">
        <img src="{{ asset('atras.png') }}" alt="" width="30" height="30" class="me-2">
        <i class="fas fa-arrow-left me-2"></i> Regresar
    </a>
</div>

@endsection
