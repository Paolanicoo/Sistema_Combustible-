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
        /* Estilos generales */
        body {
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 10px;
            max-width: 700px;
            margin-top: 30px;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f9;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-height: 500px; /* Limita la altura para forzar el scroll */
            overflow-y: auto;
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
    .read-only {
        background-color: #f0f0f0 !important; /* Color gris claro */
        color: #6c757d !important; /* Texto en gris oscuro */
        cursor: not-allowed; /* Cursor de no permitido */
        border: 1px solid #dcdcdc; /* Borde más suave */
    }

</style>

<div class="card p-4">
    <h4 class="text-center fw-bold">Resumen Importe</h4>
    <form method="post" action="{{ route('registroimporte.store') }}">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha del registro de combustible:</label>
                <input type="date" id="fecha" name="fecha" class="form-control read-only" readonly required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Seleccionar vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}" 
                            data-equipo="{{ $vehiculo->equipo }}" 
                            data-placa="{{ $vehiculo->placa }}"
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}">
                            {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control read-only" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control read-only" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control read-only" readonly>
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
                                data-consumo="{{ $combustible->entradas > 0 ? $combustible->entradas : $combustible->salidas }}">
                                {{ $combustible->num_factura }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">N° de Factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" readonly step="0.01">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-6 mb-3">
                <label for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa">TAOSA</option>
                    <option value="Clasificadora">Clasificadora</option>
                    <option value="Francisco Gusman">Francisco Gusman</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="costo">Costo</option>
                    <option value="gasto">Gasto</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-custom w-100">Guardar registro</button>
    </form>
</div>


<script>
    // Cuando se seleccione un vehículo, llena los campos relacionados
    document.getElementById('vehiculoSelect').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    
    document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
    document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
    document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
    document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
    });

    // Cuando se seleccione un combustible, llena los campos relacionados
    document.getElementById('combustibleSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];

        let fecha = selectedOption.getAttribute('data-fecha') || '';
    let numFactura = selectedOption.getAttribute('data-numfac') || '';
    let consumo = parseFloat(selectedOption.getAttribute('data-consumo')) || 0;
    let precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
    let total = consumo * precio;

    document.getElementById('fecha').value = fecha;
    document.getElementById('numfac').value = numFactura;
    document.getElementById('consumo').value = consumo;
    document.getElementById('precio').value = precio;
    document.getElementById('total').value = total.toFixed(2);

    console.log("Datos actualizados → Consumo:", consumo, "Precio:", precio, "Total:", total);
});

// Asegurar que el total no se borra antes de enviar el formulario
document.querySelector("form").addEventListener("submit", function(event) {
    let total = document.getElementById('total').value;

});
</script>

<div class="mb-3 d-flex justify-content-end">
    <a href="javascript:window.history.back();" class="btn btn-secondary px-4 w-25 d-flex align-items-center justify-content-center">
        <img src="{{ asset('atras.png') }}" alt="" width="30" height="30" class="me-2">
        <i class="fas fa-arrow-left me-2"></i> Regresar
    </a>
</div>



</body>
</html>



@endsection