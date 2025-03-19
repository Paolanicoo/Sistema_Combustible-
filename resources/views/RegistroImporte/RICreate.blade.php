@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

@section('contenido')

<style>  
    /* Estilos generales */
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-color: #f8d7da !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .card {
        border-radius: 10px;
        max-width: 900px;
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
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
        margin-top: 05px;
    }

    .read-only {
        background-color: #f0f0f0 !important; /* Color gris claro */
        color: #6c757d !important; /* Texto en gris oscuro */
        cursor: not-allowed; /* Cursor de no permitido */
        border: 1px solid #dcdcdc; /* Borde más suave */
    }

    .btn-secondary {
    background-color: #6c757d; /* Color base */
    color: white; /* Texto en blanco */
    transition: 0.3s ease-in-out;
    }

    .btn-secondary:hover {
        background-color: #5a6268; /* Oscurece el botón */
        color: black !important; /* Cambia el texto a negro */
    }

</style>

<div class="card p-4">
    <form method="post" action="{{ route('registroimporte.store') }}" id="create-form">
        @csrf
        
        <!-- Contenedor para el título y los botones alineados -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="fw-bold m-0">Resumen importe</h3>
            <div class="d-flex gap-2">
                <a href="javascript:window.history.back();" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <!-- Botón de guardar dentro del formulario -->
                <button type="submit" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control read-only" readonly required>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control" required>
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}" 
                            data-equipo="{{ $vehiculo->equipo }}" 
                            data-placa="{{ $vehiculo->placa }} "
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}">
                            {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control" required>
                    <option value="">Seleccione un registro de combustible</option>
                    @if(isset($combustibles) && $combustibles->count() > 0)
                        @foreach($combustibles as $combustible)
                            <option value="{{ $combustible->id }}" 
                                data-fecha="{{ $combustible->fecha }}" 
                                data-numfac="{{ $combustible->num_factura }}" 
                                data-precio="{{ $combustible->precio }} "
                                data-consumo="{{ $combustible->entradas > 0 ? $combustible->entradas : $combustible->salidas }} ">
                                {{ $combustible->num_factura }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">N° de Factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" readonly step="0.01">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control @error('empresa') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa">TAOSA</option>
                    <option value="Clasificadora">Clasificadora</option>
                    <option value="Francisco Gusman">Francisco Gusman</option>
                </select>
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 col-sm-6">
                <label class="form-label mb-1">Tipo:</label>
                <select id="cog" name="cog" class="form-control @error('cog') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="costo">Costo</option>
                    <option value="gasto">Gasto</option>
                </select>
                @error('cog')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
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
    });

    // Asegurarse de que el formulario se envíe correctamente
    document.getElementById('create-form').addEventListener('submit', function(event) {
        // Validar que los campos requeridos estén completos antes de enviar
        let vehiculo = document.getElementById('vehiculoSelect').value;
        let combustible = document.getElementById('combustibleSelect').value;
        let empresa = document.getElementById('empresa').value;
        let cog = document.getElementById('cog').value;
        
        if (!vehiculo || !combustible || !empresa || !cog) {
            event.preventDefault();
            alert('Por favor complete todos los campos requeridos');
        }
    });
</script>
@endsection

