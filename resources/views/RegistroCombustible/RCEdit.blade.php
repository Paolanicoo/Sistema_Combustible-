@extends('Layouts.app')

@section('titulo','Editar Registro de Combustible')

@section('contenido')

@include('sweetalert::alert')

<style>  
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #000;
        font-size: 15px; /* Tamaño base aumentado */
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
        justify-content: space-between;
        align-items: center;
    }
    
    .centered-title {
        color: #344767;
        font-weight: 530;
        margin-bottom: 0;
    }
    
    .card-body {
        padding: 1.5rem;
        background-color: #fff;
    }

    /* LABELS - Tamaño aumentado y más visibles */
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600; /* Más negrita */
        color: #344767; /* Color más oscuro */
        font-size: 1rem !important; /* 16px - Tamaño aumentado */
        letter-spacing: 0.3px;
    }

    /* INPUTS - Tamaño consistente */
    .form-control {
        width: 100%;
        padding: 10px 12px; /* Más espacio interno */
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9375rem; /* 15px */
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
    
    .text-danger {
        color: #dc3545;
        font-size: 0.8125rem; /* 13px */
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
        color: #344767;  /* Azul oscuro como el de "Regresar" */
    }

    .btn-custom:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: white;  /* Letras blancas al pasar el cursor */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
    
    textarea.form-control {
        height: 80px;
        resize: vertical;
    }
    
    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 8px;
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
        
        /* Ajustes para móviles */
        .form-label {
            font-size: 0.9375rem !important; /* 15px en móviles */
        }
    }
    .form-control.is-invalid {
    border-color: #dc3545;
    }

    .text-danger {
        color: #dc3545;
        font-size: 0.75rem;
        margin-top: 3px;
        display: block;
    } 

    .encabezado-seccion {
        background-color: #f0f0f0;
        color: #344767;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
        width: 100%;  /* Asegura que el fondo ocupe todo el ancho */
    }
</style>

<div class="card p-4">
    <form id="vehicle-form" method="post" action="{{ route('registrocombustible.update', $registro->id) }}">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center justify-content-between mb-3 position-relative">
            <!-- Título perfectamente centrado -->
            <div class="encabezado-seccion">
                <h3 class="m-0">Editar registro de combustible</h3>
            </div>
        </div>
        <div class="mb-4"></div> <!-- Espacio adicional como en el original -->

        <!-- Primera fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ $registro->fecha }}" required readonly>
                @error('fecha')
                <div class="invalid-feedback d-block">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculo">Seleccionar vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror" required>
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
                @error('id_registro_vehicular')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                <input type="text" id="num_factura" name="num_factura" class="form-control @error('num_factura') is-invalid @enderror" value="{{ $registro->num_factura }}" required oninput="validarNumeroEntero(this)">
                @error('num_factura')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="entradas">Entrada (litros):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" value="{{ number_format($registro->entradas, 3) }}" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="salidas">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" value="{{ $registro->salidas }}" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="precio">Precio por galón:</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ $registro->precio }}" required oninput="validarNumeroDecimal(this)">
                @error('precio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea class="form-control" id="observacion" name="observacion">{{ $registro->observacion }}</textarea>
                @error('observacion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- Botones alineados a la derecha -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('registrocombustible.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
    function validarNumeroDecimal(input) {
        // Eliminar caracteres no numéricos
        let value = input.value.replace(/[^0-9.]/g, '');
        
        // Evitar múltiples puntos decimales
        if ((value.match(/\./g) || []).length > 1) {
            value = value.replace(/\.+$/, "");
        }
        
        // Permitir escritura sin forzar inmediatamente 3 decimales
        input.value = value;
    }

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

        // Añadir validación de entrada para precio y salidas
        precioInput.addEventListener('input', function() {
            validarNumeroDecimal(this);
        });

        salidasInput.addEventListener('input', function() {
            validarNumeroDecimal(this);
        });

        function calcularTotal() {
            let precio = parseFloat(precioInput.value) || 0;
            let salidas = parseFloat(salidasInput.value) || 0;

            let total = precio * salidas;
            
            // Solo establecer total si existe el input
            if (totalInput) {
                totalInput.value = total.toFixed(2);
            }
        }

        // Eventos para calcular el total automáticamente
        precioInput.addEventListener('input', calcularTotal);
        salidasInput.addEventListener('input', calcularTotal);

        // Calcular el total al cargar la página si ya hay valores
        calcularTotal();
    });

    // Deshabilita el boton de actualizar, solo se habilita si hay cambios
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("vehicle-form");
        const submitButton = document.querySelector("button[form='vehicle-form']");

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
