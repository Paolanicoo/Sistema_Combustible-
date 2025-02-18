@extends('Layouts.LayoutPrincipal')

@section('titulo','Editar Importe')

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
    <h4 class="text-center font-weight-bold">Editar Importe</h4>

    <form method="post" action="{{ route('registroimporte.update', $registro->id) }}">
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
                <input type="text" id="equipo" class="form-control" value="{{ $registro->equipo }} " readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Placa:</label>
                <input type="text" id="placa" class="form-control" value="{{ $registro->placa }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Marca:</label>
                <input type="text" id="marca" class="form-control" value="{{ $registro->marca }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Asignado:</label>
                <input type="text" id="asignado" class="form-control" value="{{ $registro->asignado }}" readonly>
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
                            data-consumo="{{ $combustible->salidas }}"
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
                <input type="number" id="salidas" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Precio:</label>
                <input type="number" id="precio" class="form-control" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Total:</label>
                <input type="number" id="total" class="form-control" value="{{ $registro->total }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control">
                    <option value="Taosa" {{ $registro->empresa == 'Taosa' ? 'selected' : '' }}>TAOSA</option>
                    <option value="Clasificadora" {{ $registro->empresa == 'Clasificadora' ? 'selected' : '' }}>Clasificadora</option>
                    <option value="Francisco Gusman" {{ $registro->empresa == 'Francisco Gusman' ? 'selected' : '' }}>Francisco Gusman</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-custom">Actualizar Registro</button>
    </form>
</div>

<script>
    document.getElementById('vehiculoSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo') + " - " + selectedOption.getAttribute('data-marca');
        document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
        document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
        document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
    });

    document.getElementById('combustibleSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('numfac').value = selectedOption.getAttribute('data-numfac');
        document.getElementById('salidas').value = selectedOption.getAttribute('data-consumo');
        document.getElementById('precio').value = selectedOption.getAttribute('data-precio');
    });
</script>

@endsection
