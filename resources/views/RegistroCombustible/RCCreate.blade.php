@extends('Layouts.app')

@section('titulo','creacion de registro Combustible')

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
        justify-content: flex-end; /* Alinea los botones a la derecha */
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
    }
    
    .form-control[readonly] {
        background-color: #f0f0f0;
        color: #344767; /* mismo color del texto del título */
        cursor: not-allowed; /* opcional, para mostrar que no se puede editar */
    }

</style>

<div class="card p-4">
    <form method="post" action="{{ route('registrocombustible.store') }}">
        @csrf
        <div class="encabezado-seccion">
            <h3 class="m-0">Registro de combustible</h3>
        </div>

        <div class="mb-4"></div> <!-- Puedes ajustar mb-4 a mb-3, mb-5, etc. -->
        
        <!-- Primera fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror">
                @error('fecha')
                <div class="invalid-feedback d-block">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="vehiculo">Seleccionar vehículo:</label>
                <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control @error('id_registro_vehicular') is-invalid @enderror">
                    <option value="">Seleccione un vehículo</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}"
                            data-equipo="{{ $vehiculo->equipo }}"
                            data-placa="{{ $vehiculo->placa }}"
                            data-marca="{{ $vehiculo->marca }}"
                            data-asignado="{{ $vehiculo->asignado }}">
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
                <input type="text" id="equipo" name="equipo" class="form-control" readonly>
            </div>
        </div>

        <!-- Segunda fila (3 campos) -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" readonly>
            </div>
        </div>

        <!-- Tercera fila (4 campos) -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="num_factura">Número de factura:</label>
                <input type="text" id="num_factura" name="num_factura" class="form-control @error('num_factura') is-invalid @enderror" oninput="validarNumeroEntero(this)">
                @error('num_factura')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="entradas">Entrada (litros):</label>
                <input type="text" id="entradas" name="entradas" class="form-control" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="salidas">Salida (galones):</label>
                <input type="text" id="salidas" name="salidas" class="form-control" oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="precio">Precio por galón:</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" oninput="validarNumeroDecimal(this)">
                @error('precio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="observacion" class="form-label">Observación (opcional):</label>
                <textarea class="form-control" id="observacion" name="observacion"></textarea>
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
    document.getElementById('entradas').addEventListener('input', function () {
        let value = parseFloat(this.value).toFixed(3);  // Limitar a 3 decimales
        this.value = value; // Establece el valor con 3 decimales
    });
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Solo permite números enteros
    }

    function validarNumeroDecimal(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite números y un solo punto
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, ""); // Evita múltiples puntos decimales
        }
    }
</script>

<script>
    function validarNumeroEntero(input) {
        input.value = input.value.replace(/\D/g, ''); // Elimina cualquier caracter que no sea número
    }
</script>

<script>
    function validarNumero(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite solo números y punto decimal
    }
</script>


<script>
    window.onload = function() {
        var today = new Date(); // Obtiene la fecha actual
        var dd = String(today.getDate()).padStart(2, '0'); // Día
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes (enero es 0)
        var yyyy = today.getFullYear(); // Año

        today = yyyy + '-' + mm + '-' + dd; // Formato yyyy-mm-dd

        document.getElementById('fecha').value = today; // Asigna la fecha actual al campo
    }

    document.getElementById('vehiculoSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        
        document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
        document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
        document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
        document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
    });

    function validarCampos() {
        let entradas = document.getElementById('entradas').value;
        let salidas = document.getElementById('salidas').value;

        // Limpiar mensajes de error
        document.getElementById('errorEntradas').innerText = "";
        document.getElementById('errorSalidas').innerText = "";

        // Hacer opcional la entrada o salida, pero no ambas vacías
        if (!entrada && !salida) {
            document.getElementById('errorEntradas').innerText = "Debe ingresar entrada o salida.";
            document.getElementById('errorSalidas').innerText = "Debe ingresar entrada o salida.";
        } else {
            calcularTotal();
        }
    }

</script>
@endsection