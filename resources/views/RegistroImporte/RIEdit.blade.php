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
                <input type="date" name="fecha" class="form-control" value="{{ $registro->fecha }}" readonly>
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

            <div class="col-md-6 mb-3">
                <label class="form-label">Vehículo:</label>
                <input type="text" class="form-control" value="{{ $registro->equipo }} - {{ $registro->marca }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Placa:</label>
                <input type="text" class="form-control" value="{{ $registro->placa }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Asignado:</label>
                <input type="text" class="form-control" value="{{ $registro->asignado }}" readonly>
            </div>
        </div>

        <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Seleccionar registro de combustible:</label>
        <select id="combustibleSelect" name="id_registro_combustible" class="form-control" required>
            <option value="">Seleccione un registro de combustible</option>
            @if(isset($combustibles) && $combustibles->count() > 0)
                @foreach($combustibles as $combustible)
                    <option value="{{ $combustible->id }}" 
                        data-fecha="{{ $combustible->fecha }}" 
                        data-numfac="{{ $combustible->num_factura }}" 
                        data-precio="{{ $combustible->precio }}"
                        data-consumo="{{ $combustible->salidas }}">
                        {{ $combustible->num_factura }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-6 mb-3">
            <label class="form-label">N° de Factura:</label>
            <input type="number" id="numfac" name="numfac" class="form-control" readonly>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Consumo:</label>
            <input type="number" id="salidas" name="salidas" class="form-control" readonly step="0.01"readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" readonly>
        </div>
    </div>


        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Total:</label>
                <input type="number" class="form-control" value="{{ $registro->total }}" step="0.01" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa" {{ $registro->empresa == 'Taosa' ? 'selected' : '' }}>TAOSA</option>
                    <option value="Clasificadora" {{ $registro->empresa == 'Clasificadora' ? 'selected' : '' }}>Clasificadora</option>
                    <option value="Francisco Gusman" {{ $registro->empresa == 'Francisco Gusman' ? 'selected' : '' }}>Francisco Gusman</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="costo" {{ $registro->cog == 'costo' ? 'selected' : '' }}>Costo</option>
                    <option value="gasto" {{ $registro->cog == 'gasto' ? 'selected' : '' }}>Gasto</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-custom">Actualizar Registro</button>
    </form>
</div>

@endsection
