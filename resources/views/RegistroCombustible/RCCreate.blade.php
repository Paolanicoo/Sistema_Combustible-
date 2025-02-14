@extends('Layouts.LayoutPrincipal')

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
        
        .header {
            background-color: #333; 
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 10px;
            max-width: 700px;
            margin-top: 30px; /* Subir el formulario un poco */
            margin-left: auto;
            margin-right: auto;
        }
        .card-header {
            background-color:rgba(253, 254, 255, 0.98); 
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: black; /* Letras en negro */
            text-align: center;
            padding: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control, .btn {
            border-radius: 8px;
        }
        .btn-custom {
            background-color:rgb(53, 192, 88);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            width: 100%;
        } 
    </style>

<form method="post" action="{{ route('registrocombustible.store') }}">
    @csrf  {{-- Muy importante para los formularios de creación y edición --}}

    <div class="mb-3">
                    <label class="form-label">Fecha:</label>
                    <input type="date" name="fecha" class="form-control"  required>
                </div>

<div class="mb-3">
    <label>Seleccionar Vehículo:</label>

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
</div>

<div class="mb-3">
    <label>Equipo:</label>
    <input type="text" id="equipo" name="equipo" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Placa:</label>
    <input type="text" id="placa" name="placa" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Marca:</label>
    <input type="text" id="marca" name="marca" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Asignado:</label>
    <input type="text" id="asignado" name="asignado" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Numero de Factura:</label>
    <input type="number" id="num_factura" name="num_factura" class="form-control">
</div>

<div class="mb-3">
    <label>Entrada:</label>
    <input type="text" id="entradas" name="entradas" class="form-control" >
</div>

<div class="mb-3">
    <label>Salida:</label>
    <input type="text" id="salidas" name="salidas" class="form-control" >
</div>

<div class="mb-3">
    <label>Precio:</label>
    <input type="number" id="precio" name="precio" class="form-control" >
</div>

<button type="submit" class="btn btn-custom">Guardar Registro</button>

</form>

<script>
document.getElementById('vehiculoSelect').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    
    document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
    document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
    document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
    document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
});
</script>

@endsection
