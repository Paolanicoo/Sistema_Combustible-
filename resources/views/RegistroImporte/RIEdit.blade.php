@extends('Layouts.app')

@section('titulo','Editar Importe')

@section('contenido')

<style>
    /* Estilos base */
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

    /* Labels */
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #344767;
        font-size: 1rem !important;
        letter-spacing: 0.3px;
    }

    /* Inputs */
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        color: #344767;
    }

    .form-control:focus {
        border-color: #0ea5e9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    /* Campos de solo lectura */
    .form-control[readonly],
    .form-control.read-only {
        background-color: #f1f1f1 !important;
        color: #6c757d !important;
        cursor: not-allowed;
        border: 1px solid #e2e8f0;
    }

    .text-danger {
        color: #dc3545;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }

    /* Botones */
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
        color: #000; /* Texto negro por defecto */
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
        color: #000; /* Texto negro por defecto */
    }

    .btn-custom:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: #ffffff !important; /* Texto blanco al pasar el mouse */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }

    .btn-custom:hover i {
        color: #ffffff !important; /* También cambia el color del ícono */
    }

    /* Estilo para el botón deshabilitado */
    .btn[disabled], .btn:disabled {
        background-color: #0ea5e9 !important;  /* Fondo azul */
        color: #000 !important;                /* Texto negro */
        border-color: #0ea5e9 !important;     /* Borde azul */
        cursor: not-allowed;                  /* Cursor no permitido */
        pointer-events: none;                 /* Desactiva las interacciones */
    }

    textarea.form-control {
        height: 80px;
        resize: vertical;
    }

    /* Botones de acción */
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

    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }

        .form-label {
            font-size: 0.9375rem !important;
        }
    }

    .encabezado-seccion {
        background-color: #f0f0f0;
        color: #344767;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* === NUEVO: Estilo para cuando el botón está deshabilitado === */
    .btn-custom:disabled,
    .btn-custom[disabled] {
        background-color: #0ea5e9 !important;
        border-color: #0ea5e9 !important;
        color: #344767 !important;
        opacity: 1 !important;        /* Asegura que no se vea opaco */
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
</style>

<div class="card p-4">
    <form method="post" action="{{ route('registroimporte.update', $registro->id) }}" id="update-form">
        @csrf
        @method('PUT')
        
        <div class="encabezado-seccion">
            <h3 class="m-0">Editar resumen importe</h3>
        </div>

        <div class="mb-4"></div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control read-only" value="{{ old('fecha', $registro->fecha ?? '') }}" readonly required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculoSelect">Vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
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
                @error('id_registro_vehicular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" class="form-control read-only" value="{{ old('equipo', $registro->equipo) }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" class="form-control read-only" value="{{ old('placa', $registro->placa) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" class="form-control read-only" value="{{ old('marca', $registro->marca) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" class="form-control read-only" value="{{ old('asignado', $registro->asignado) }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="combustibleSelect">Registro de combustible:</label>
                <select id="combustibleSelect" name="id_registro_combustible" class="form-control @error('id_registro_combustible') is-invalid @enderror" required>
                    <option value="">Seleccione un registro de combustible</option>
                    @foreach($combustibles as $combustible)
                    <option value="{{ $combustible->id }}" 
                        data-fecha="{{ $combustible->fecha }}" 
                        data-numfac="{{ $combustible->num_factura }}" 
                        data-precio="{{ $combustible->precio }}"
                        data-consumo="{{ $combustible->entradas > 0 ? $combustible->entradas : $combustible->salidas }}"
                        {{ $combustible->id == $registro->id_registro_combustible ? 'selected' : '' }}>
                        {{ $combustible->num_factura }}
                    </option>
                    @endforeach
                </select>
                @error('id_registro_combustible')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="numfac">N° de Factura:</label>
                <input type="number" id="numfac" class="form-control read-only" value="{{ old('numfac', $registro->numfac) }}" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="consumo">Consumo:</label>
                <input type="number" id="consumo" name="consumo" class="form-control read-only" value="{{ old('consumo', $registro->consumo) }}" readonly step="0.01">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control read-only" value="{{ old('precio', $registro->precio) }}" readonly step="0.01">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="total">Total:</label>
                <input type="number" id="total" name="total" class="form-control read-only" value="{{ old('total', $registro->total) }}" readonly step="0.01">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="empresa">Empresa:</label>
                <select id="empresa" name="empresa" class="form-control @error('empresa') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Taosa" {{ old('empresa', $registro->empresa) == 'Taosa' ? 'selected' : '' }}>TAOSA</option>
                    <option value="Clasificadora" {{ old('empresa', $registro->empresa) == 'Clasificadora' ? 'selected' : '' }}>Clasificadora</option>
                    <option value="Francisco Gusman" {{ old('empresa', $registro->empresa) == 'Francisco Gusman' ? 'selected' : '' }}>Francisco Gusman</option>
                </select>
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="cog">Tipo:</label>
                <select id="cog" name="cog" class="form-control editable @error('cog') is-invalid @enderror" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Costo" {{ old('cog', $registro->cog) && strtolower(old('cog', $registro->cog)) == 'costo' ? 'selected' : '' }}>Costo</option>
                    <option value="Gasto" {{ old('cog', $registro->cog) && strtolower(old('cog', $registro->cog)) == 'gasto' ? 'selected' : '' }}>Gasto</option>
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
                        <i class="fas fa-sync-alt me-1"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Campos ocultos -->
        <input type="hidden" name="equipo" value="{{ old('equipo', $registro->equipo) }}">
        <input type="hidden" name="placa" value="{{ old('placa', $registro->placa) }}">
        <input type="hidden" name="marca" value="{{ old('marca', $registro->marca) }}">
        <input type="hidden" name="asignado" value="{{ old('asignado', $registro->asignado) }}">
        <input type="hidden" name="numfac" value="{{ old('numfac', $registro->numfac) }}">
        <input type="hidden" name="consumo" value="{{ old('consumo', $registro->consumo) }}">
        <input type="hidden" name="precio" value="{{ old('precio', $registro->precio) }}">
        <input type="hidden" name="total" value="{{ old('total', $registro->total) }}">
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
                let consumo = parseFloat(selectedOption.getAttribute('data-consumo')) || 0;
                
                // Calcular el total
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("update-form");
        const submitButton = document.querySelector("button[type='submit']");

        // Deshabilitar el botón al inicio
        submitButton.disabled = true;

        // Guardar valores originales
        const initialFormData = new FormData(form);

        form.addEventListener("input", function () {
            const currentFormData = new FormData(form);
            let hasChanges = false;

            // Comparar los valores actuales con los originales
            for (let [key, value] of currentFormData.entries()) {
                if (value !== initialFormData.get(key)) {
                    hasChanges = true;
                    break;
                }
            }

            // Habilitar o deshabilitar el botón según haya cambios
            submitButton.disabled = !hasChanges;
        });
    });
</script>

@endsection
