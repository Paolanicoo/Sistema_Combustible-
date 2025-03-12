@extends('Layouts.app')

@section('titulo','Editar Importe')

@section('contenido')


<style>  
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    .card {
        border-radius: 10px;
        max-width: 700px;
        margin: 30px auto;
        background-color: #f9f9f9;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
</style>

<div class="card">
    <h4 class="text-center font-weight-bold">Editar importe</h4>
    <form method="post" action="{{ route('registroimporte.update', $registro->id) }}" id="update-form">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $registro->fecha ?? '') }}" readonly>
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
                            {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Vehículo:</label>
                <input type="text" id="equipo" class="form-control" value="{{ old('equipo', $registro->equipo) }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Placa:</label>
                <input type="text" id="placa" class="form-control" value="{{ old('placa', $registro->placa) }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Marca:</label>
                <input type="text" id="marca" class="form-control" value="{{ old('marca', $registro->marca) }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Asignado:</label>
                <input type="text" id="asignado" class="form-control" value="{{ old('asignado', $registro->asignado) }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Seleccionar registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control" required>
                    <option value="">Seleccione un registro de combustible</option>
                    @foreach($combustibles as $combustible)
                        <option value="{{ $combustible->id }}" 
                            data-fecha="{{ $combustible->fecha }}" 
                            data-numfac="{{ $combustible->num_factura }}" 
                            data-precio="{{ $combustible->precio }}"
                            data-entradas="{{ $combustible->entradas ?? 0 }}"
                            data-salidas="{{ $combustible->salidas ?? 0 }}"
                            {{ $combustible->id == $registro->id_registro_combustible ? 'selected' : '' }}>
                            {{ $combustible->num_factura }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° de Factura:</label>
                <input type="number" id="numfac" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Consumo:</label>
                <input type="number" id="consumo" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Precio:</label>
                <input type="number" id="precio" class="form-control" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Total:</label>
                <input type="number" id="total" class="form-control" value="{{ old('total', $registro->total) }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control">
                    <option value="Taosa" {{ old('empresa', $registro->empresa) == 'Taosa' ? 'selected' : '' }}>TAOSA</option>
                    <option value="Clasificadora" {{ old('empresa', $registro->empresa) == 'Clasificadora' ? 'selected' : '' }}>Clasificadora</option>
                    <option value="Francisco Gusman" {{ old('empresa', $registro->empresa) == 'Francisco Gusman' ? 'selected' : '' }}>Francisco Gusman</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipo">Tipo:</label>
                <select id="cog" name="cog" class="form-control">
                    <option value="Gasto" {{ old('cog', $registro->tipo) == 'Gasto' ? 'selected' : '' }}>Gasto</option>
                    <option value="Costo" {{ old('cog', $registro->tipo) == 'Costo' ? 'selected' : '' }}>Costo</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-custom">Actualizar registro</button>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let vehiculoSelect = document.getElementById('vehiculoSelect');
        let combustibleSelect = document.getElementById('combustibleSelect');

        function actualizarDatosVehiculo() {
            let selectedOption = vehiculoSelect.options[vehiculoSelect.selectedIndex];
            if (selectedOption) {
                document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo') || '';
                document.getElementById('placa').value = selectedOption.getAttribute('data-placa') || '';
                document.getElementById('marca').value = selectedOption.getAttribute('data-marca') || '';
                document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado') || '';
            }
        }

        function actualizarDatosCombustible() {
            let selectedOption = combustibleSelect.options[combustibleSelect.selectedIndex];
            if (selectedOption) {
                let fecha = selectedOption.getAttribute('data-fecha') || '';  
                let numFac = selectedOption.getAttribute('data-numfac') || '';
                let precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;

                // Obtener valores de entradas y salidas
                let entradas = parseFloat(selectedOption.getAttribute('data-entradas')) || 0;
                let salidas = parseFloat(selectedOption.getAttribute('data-salidas')) || 0;

                // Determinar el consumo: si hay salidas, usarlas. Si no, usar entradas.
                let consumo = salidas > 0 ? salidas : entradas;

                let total = consumo * precio;

                document.getElementById('fecha').value = fecha;
                document.getElementById('numfac').value = numFac;
                document.getElementById('consumo').value = consumo.toFixed(2);
                document.getElementById('precio').value = precio.toFixed(2);
                document.getElementById('total').value = total.toFixed(2);
            } else {
                console.log("⚠ No se encontró ninguna opción seleccionada en el select de combustible.");
            }
        }

        vehiculoSelect.addEventListener('change', actualizarDatosVehiculo);
        combustibleSelect.addEventListener('change', actualizarDatosCombustible);

        // Inicializar los datos cuando la página carga
        if (vehiculoSelect.value) {
            actualizarDatosVehiculo();
        }
        if (combustibleSelect.value) {
            actualizarDatosCombustible();
        }
    });
</script>
<div class="mb-3 d-flex justify-content-end">
    <a href="javascript:window.history.back();" class="btn btn-secondary px-4 w-25 d-flex align-items-center justify-content-center">

        <i class="fas fa-arrow-left me-2"></i> Regresar
    </a>
</div>
