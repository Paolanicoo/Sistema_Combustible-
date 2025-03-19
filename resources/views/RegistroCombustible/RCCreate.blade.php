@extends('Layouts.app')

@section('titulo','combustible')

@section('contenido')

<style>
    /* Estilos generales */
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    /* Estilos para los campos deshabilitados */
    .form-control[readonly], .form-control[disabled] {
        background-color: #f0f0f0; /* Fondo gris claro */
        color: #888; /* Texto gris para indicar que están bloqueados */
        cursor: not-allowed; /* Cambiar el cursor para indicar que no son interactivos */
    }

    .card {
        border-radius: 10px;
        max-width: 900px;
        margin-top: 50px;
        margin-left: auto;
        margin-right: auto;
        background-color: #f9f9f9;
        padding: 50px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        min-height: 450px; /* Aumenta la altura del formulario */
        height: auto; /* Asegura que la altura se ajuste automáticamente al contenido */
    }

    .card-header {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 24px;
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: bold;
    }

    .form-control, .btn {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #66afe9;
        outline: none;
    }

    .btn-custom {
        background-color: rgb(53, 192, 88);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        width: 100%;
        border: none;
    }

    .btn-custom:hover {
        background-color: rgb(40, 160, 70);
        transition: 0.3s ease-in-out;
    }

    .centered-title {
        text-align: center;
        font-weight: bold;
        margin-top: 20px;
    }

    .text-danger {
        color: red;
        font-size: 14px;
    }

    /* Estilo de los campos de formulario */
    .form-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px; /* Aumenta el margen entre filas */
    }

    .col-md-4 {
        flex: 1 1 32%;
    }

    .col-md-3 {
        flex: 1 1 23%;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .small-input {
        width: 100%;
        font-size: 0.85rem;
    }

</style>

<div class="card p-4">
    <form method="post" action="{{ route('registrocombustible.store') }}">
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Crear Registro de Combustible</h4>
            <div class="d-flex gap-2">
                <a href="javascript:window.history.back();" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        <!-- Primera fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculo">Seleccionar vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control" required>
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
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" readonly>
            </div>
        </div>

        <!-- Segunda fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" readonly>
            </div>
        </div>

        <!-- Tercera fila (4 campos) -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="num_factura">Número de factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control" required oninput="validarNumeroEntero(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="entradas">Entrada (galones):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="salidas">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="precio">Precio por galón:</label>
                <input type="text" id="precio" name="precio" class="form-control" required oninput="validarNumeroDecimal(this)">
            </div>
        </div>
    </form>
</div>




<script>
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Solo permite números enteros
    }

    function validarNumeroDecimal(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite números y un solo punto
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, ""); // Evita múltiples puntos decimales
        }
    }
</script>

<script>
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Elimina cualquier caracter que no sea número
    }
</script>

<script>
    function validarNumero(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite solo números y punto decimal
    }
</script>


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
@endsection