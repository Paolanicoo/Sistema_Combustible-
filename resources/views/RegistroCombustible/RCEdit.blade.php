@extends('Layouts.app')

@section('titulo','Editar Registro de Combustible')

@section('contenido')

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

    .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: #344767;
    }

    .btn-info:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: white;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }

    /* === NUEVO: Estilo para cuando el botón está deshabilitado === */
    .btn-info:disabled,
    .btn-info[disabled] {
        background-color: #0ea5e9 !important;
        border-color: #0ea5e9 !important;
        color: #344767 !important;
        opacity: 1 !important;        /* Asegura que no se vea opaco */
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
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

    .form-control[readonly] {
        background-color: #f0f0f0;
        color: #344767; /* mismo color del texto del título */
        cursor: not-allowed; /* opcional, para mostrar que no se puede editar */
    }
    
</style>

<div class="card p-4">
    <form id="vehicle-form" method="post" action="{{ route('registrocombustible.update', $registro->id) }}">
        @csrf
        @method('PUT')
        <div class="encabezado-seccion mb-4">
            <h3 class="m-0">Editar registro de combustible</h3>
        </div>

        <!-- Fila 1 (3 campos) -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ $registro->fecha }}" required >
                @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-4">
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
                            {{ $vehiculo->equipo }} - {{ $vehiculo->placa }}
                        </option>
                    @endforeach
                </select>
                @error('id_registro_vehicular') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label" for="num_factura">No. Factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control @error('num_factura') is-invalid @enderror" value="{{ $registro->num_factura }}" required oninput="validarNumeroEntero(this)">
                @error('num_factura') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Fila 2 (Datos del vehículo - 4 campos) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control" value="{{ $registro->equipo }}" readonly>
                @error('equipo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" value="{{ $registro->placa }}" readonly>
                @error('placa') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="{{ $registro->marca }}" readonly>
                @error('marca') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" value="{{ $registro->asignado }}" readonly>
                @error('asignado') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Fila 3 (4 campos) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label" for="tipo">Tipo de Medida:</label>
                <select id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                <option value="galones" {{ old('tipo', $registro->tipo) === 'galones' ? 'selected' : '' }}>Galones</option>
                <option value="litros" {{ old('tipo', $registro->tipo) === 'litros' ? 'selected' : '' }}>Litros</option>
                </select>
                
                @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="entradas">Entrada:</label>
                <input type="text" id="entradas" name="entradas" class="form-control" value="{{ old('entradas', $registro->entradas) }}" oninput="validarNumeroDecimal(this)">

                @error('entradas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="salidas">Salida:</label>
                <input type="text" id="salidas" name="salidas" class="form-control" value="{{ $registro->salidas }}" oninput="validarNumeroDecimal(this)">
                @error('salidas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label" for="precio">Precio por Galón:</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ $registro->precio }}" required oninput="validarNumeroDecimal(this)">
                @error('precio') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Fila 4 (Solo observación) -->
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label" for="observacion">Observaciones:</label>
                <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="60">{{ $registro->observacion }}</textarea>
                @error('observacion') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-3 mt-4">
            <a href="{{ route('registrocombustible.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
            <button type="submit" class="btn btn-info">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </div>
    </form>
</div>

<script>
   function validarNumeroDecimal(input) {
    let value = input.value.replace(/[^0-9.]/g, ''); // Elimina caracteres no válidos
    let parts = value.split('.');// Divide el número por el punto decimal
     // Si hay más de un punto, conserva la parte antes del primer punto y los primeros 3 dígitos después del punto
    if (parts.length > 1) {
        value = parts[0] + '.' + parts[1].slice(0, 2); // Limita a 3 dígitos después del punto
    }
    input.value = value;
}

let valorOriginalEntradas = null;

function convertirEntradas() {
    const tipo = document.getElementById('tipo').value;
    const entradasInput = document.getElementById('entradas');

    if (valorOriginalEntradas === null) {
        valorOriginalEntradas = parseFloat(entradasInput.value) || 0;
    }

    let convertido;
    if (tipo === 'litros') {
        convertido = valorOriginalEntradas * 3.78541;
    } else {
        convertido = valorOriginalEntradas;
    }

    entradasInput.value = convertido.toFixed(2);
}

document.getElementById('tipo').addEventListener('change', () => {
    // Reset para permitir reconversión desde el valor original
    valorOriginalEntradas = parseFloat(document.getElementById('entradas').value) || 0;
    convertirEntradas();
});


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

   
    // Deshabilitar de actualizar
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("vehicle-form");
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
