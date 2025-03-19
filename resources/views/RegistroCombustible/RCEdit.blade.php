@extends('Layouts.app')

@section('titulo','Editar Registro de Combustible')

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
    <form method="post" action="{{ route('registrocombustible.update', $registro->id) }}">
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Editar Registro de Combustible</h4>
            <div class="d-flex gap-2">
                <a href="javascript:window.history.back();" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Primera fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $registro->fecha }}" required readonly>
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
                            data-asignado="{{ $vehiculo->asignado }}" 
                            {{ $vehiculo->id == $registro->id_registro_vehicular ? 'selected' : '' }}>
                            {{ $vehiculo->equipo }} - {{ $vehiculo->placa }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" value="{{ $registro->equipo }}" readonly>
            </div>
        </div>

        <!-- Segunda fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" value="{{ $registro->placa }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="{{ $registro->marca }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" value="{{ $registro->asignado }}" readonly>
            </div>
        </div>

        <!-- Tercera fila (4 campos) -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="num_factura">Número de factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control" value="{{ $registro->num_factura }}" required oninput="validarNumeroEntero(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="entradas">Entrada (galones):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" value="{{ $registro->entradas }}" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="salidas">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" value="{{ $registro->salidas }}" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="precio">Precio por galón:</label>
                <input type="text" id="precio" name="precio" class="form-control" value="{{ $registro->precio }}" required oninput="validarNumeroDecimal(this)">
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let vehiculoSelect = document.getElementById('vehiculoSelect');

    function actualizarDatosVehiculo() {
        var selectedOption = vehiculoSelect.options[vehiculoSelect.selectedIndex];

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
@endsection
