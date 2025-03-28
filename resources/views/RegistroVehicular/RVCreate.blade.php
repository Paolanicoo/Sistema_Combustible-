@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

@section('contenido')
@include('sweetalert::alert')

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
            padding: 20px; /* Espacio interior */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }

        .card-header {
            background-color: #333; /* Fondo oscuro para la cabecera */
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra en la cabecera */
        }

        .form-label {
            font-weight: bold;
        }

        .form-control, .btn {
            border-radius: 8px;
            border: 1px solid #ccc; /* Borde sutil */
            padding: 10px;
            width: 100%;
        }

        .form-control:focus {
            background-color: #fff; /* Fondo blanco al hacer foco */
            border-color: #66afe9; /* Borde azul claro al hacer foco */
            outline: none; /* Eliminar el borde del foco por defecto */
        }

        .btn-custom {
            background-color: rgb(53, 192, 88); /* Verde para el botón */
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            width: 100%;
            border: none;
        }

        .btn-custom:hover {
            background-color: rgb(40, 160, 70); /* Verde más oscuro al pasar el mouse */
            transition: 0.3s ease-in-out;
        }

        .centered-title {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .text-danger {
            color: red;
            font-size: 14px;
        }

        /* Estilo de los campos de formulario */
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6 {
            flex: 1 1 48%;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        textarea.form-control {
            resize: vertical; /* Permite redimensionar el área de texto solo verticalmente */
        }
    </style>

<div class="card p-4">
    <form method="post" action="{{ route('registrovehicular.store') }}">
        @csrf 

        <!-- Contenedor para el título y los botones alineados -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Registro de vehículo</h4>
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

        <!-- Campos del formulario -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" id="equipo" name="equipo" class="form-control @error('equipo') is-invalid @enderror" value="{{ old('equipo') }}" maxlength="20" required>
                @error('equipo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control @error('placa') is-invalid @enderror" value="{{ old('placa') }}" oninput="formatPlaca(this)" placeholder="Ej: ABC 1234">
                @error('placa')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="motor">Motor:</label>
                <input type="text" id="motor" name="motor" class="form-control @error('motor') is-invalid @enderror" value="{{ old('motor') }}" maxlength="35">
                @error('motor')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca') }}" maxlength="25">
                @error('marca')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo') }}" maxlength="30">
                @error('modelo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="serie">Serie:</label>
                <input type="text" id="serie" name="serie" class="form-control @error('serie') is-invalid @enderror" value="{{ old('serie') }}" maxlength="25">
                @error('serie')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control @error('asignado') is-invalid @enderror" value="{{ old('asignado') }}" maxlength="30" required>
                @error('asignado')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="observacion">Observación (opcional):</label>
                <textarea id="observacion" name="observacion" class="form-control @error('observacion') is-invalid @enderror" rows="3" maxlength="40">{{ old('observacion') }}</textarea>
                @error('observacion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>
</div>


<!-- Formateo de la placa -->
<script>
    function formatPlaca(input) {
        let value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, ""); // Solo letras y números

        // Evitar que inicie con números
        if (value.length > 0 && !isNaN(value[0])) {
            value = value.substring(1);  // Elimina el primer número si empieza con uno
        }

        // Limita las letras a solo las primeras 3
        if (value.length > 3) {
            value = value.slice(0, 3) + " " + value.slice(3); // Añade espacio después de las primeras 3 letras
        }

        // Asegurarse que después del espacio solo haya números
        if (value.indexOf(" ") !== -1) {
            let parts = value.split(" "); // Separa la parte antes y después del espacio
            parts[0] = parts[0].slice(0, 3).replace(/[^A-Z]/g, ""); // Limita la parte antes del espacio a solo 3 letras
            parts[1] = parts[1].replace(/[^0-9]/g, ""); // La parte después del espacio solo números
            value = parts.join(" "); // Vuelve a juntar las partes
        }

        // Limita la longitud total a 8 caracteres
        if (value.length > 8) {
            value = value.slice(0, 8);
        }

        input.value = value.trim(); // Elimina espacios extra al final
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection

