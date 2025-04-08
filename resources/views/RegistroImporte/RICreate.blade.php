@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

@section('contenido')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #000;
        font-size: 15px;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 50px auto;
        max-width: 900px;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .centered-title {
        color: #344767;
        font-weight: 530;
        margin-bottom: 0;
        text-align: center;
    }

    .card-body {
        padding: 1.5rem;
        background-color: #fff;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #344767;
        font-size: 1rem !important;
        letter-spacing: 0.3px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        color: #344767;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: #0ea5e9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control[readonly] {
        background-color: #f1f1f1 !important;
        color: #6c757d !important;
        cursor: not-allowed;
    }

    .text-danger, .invalid-feedback {
        color: #dc3545;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: #344767;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-custom {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: #000; /* Letra negra normalmente */
    }

    .btn-custom:hover,
    .btn-custom:active,
    .btn-custom:focus {
        background-color: #0284c7;
        border-color: #0284c7;
        color: #ffffff; /* Letra blanca al presionar o pasar el mouse */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }

    textarea.form-control {
        height: 80px;
        resize: vertical;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .encabezado-seccion {
        background-color: #f0f0f0;
        color: #344767;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }

        .form-label {
            font-size: 0.9375rem !important;
        }
    }
</style>


<div class="card p-4">
    <form method="post" action="{{ route('registroimporte.store') }}" id="create-form">
        @csrf
        
        <div class="encabezado-seccion">
            <h3 class="m-0">Resumen importe</h3>
        </div>

        <div class="mb-4"></div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control read-only" readonly required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
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
                @error('id_registro_vehicular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control read-only" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="combustibleSelect">Registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control @error('id_registro_combustible') is-invalid @enderror" required>
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
                @error('id_registro_combustible')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="numfac">N° de Factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control read-only" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="consumo">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" readonly step="0.01">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="total">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" readonly step="0.01">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="empresa">Empresa:</label>
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

        <div class="row">
            <div class="col-md-4 mb-3">
            <label class="form-label" for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control @error('cog') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="costo">Costo</option>
                    <option value="gasto">Gasto</option>
                </select>
                @error('cog')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Botones alineados a la derecha en la misma fila que el último campo -->
            <div class="col-md-8 mb-3 d-flex justify-content-end align-items-end">
                <div class="d-flex gap-3">
                    <a href="{{ route('registroimporte.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
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

