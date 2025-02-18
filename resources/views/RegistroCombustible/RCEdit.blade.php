
@extends('Layouts.LayoutPrincipal')

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

<div class="form-container">
    <h4 class="centered-title">Editar Registro de Combustible</h4>

    <form method="post" action="{{ route('registrocombustible.update', $registro->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $registro->fecha }}" required>
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
                {{ $vehiculo->id == $registro->id_registro_vehicular ? 'selected' : '' }}>
                {{ $vehiculo->placa }} - {{ $vehiculo->marca }}
            </option>
        @endforeach
    </select>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="equipo" class="form-label">Equipo:</label>
        <input type="text" id="equipo" name="equipo" class="form-control" readonly value="{{ $registro->vehiculo->equipo ?? '' }}">
    </div>

    <div class="col-md-6 form-group">
        <label for="placa" class="form-label">Placa:</label>
        <input type="text" id="placa" name="placa" class="form-control" readonly value="{{ $registro->vehiculo->placa ?? '' }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="marca" class="form-label">Marca:</label>
        <input type="text" id="marca" name="marca" class="form-control" readonly value="{{ $registro->vehiculo->marca ?? '' }}">
    </div>

    <div class="col-md-6 form-group">
        <label for="asignado" class="form-label">Asignado:</label>
        <input type="text" id="asignado" name="asignado" class="form-control" readonly value="{{ $registro->vehiculo->asignado ?? '' }}">
    </div>
</div>



        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="num_factura" class="form-label">Número de factura:</label>
                <input type="number" id="num_factura" name="num_factura" class="form-control" value="{{ $registro->num_factura }}" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="entradas" class="form-label">Entrada (galones):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" value="{{ $registro->entradas }}" >
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="salidas" class="form-label">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" value="{{ $registro->salidas }}" required>
            </div>

            <div class="col-md-6 form-group">
                <label for="precio" class="form-label">Precio por galón:</label>
                <input type="number" id="precio" name="precio" class="form-control" value="{{ $registro->precio }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="total" class="form-label">Total:</label>
                <input type="number" id="total" name="total" class="form-control" value="{{ $registro->entradas * $registro->precio }}" readonly>
            </div>
        </div>

        <button type="submit" class="btn-submit">Actualizar registro</button>
    </form>
</div>

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


@endsection
