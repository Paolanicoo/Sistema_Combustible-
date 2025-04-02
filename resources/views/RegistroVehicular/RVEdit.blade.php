@extends('Layouts.app')

@section('titulo', 'Editar Vehículo')

@section('contenido')
@include('sweetalert::alert')

<style>  
    /* Estilos adaptados al diseño principal */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #000; /* Cambiado a negro para todo el texto en el body */
    }
    
    .vehicle-form-card {
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
        color: #000; /* Cambiado a negro */
    }
    
    .card-title { 
        color: #344767; /* Color azul */
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .card-body {
        padding: 1.5rem;
        background-color: #fff;
        color: #000; /* Cambiado a negro */
    }
    
    /* Form layout - más compacto */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: -8px;
    }
    
    .form-group {
        flex: 1 1 calc(50% - 16px);
        min-width: 250px;
        padding: 8px;
        margin-bottom: 5px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #344767; /* Color azul */
        font-size: 0.875rem;
    }
    
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        color: #344767; /* Color azul en los textos */
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
        font-size: 0.75rem;
        margin-top: 3px;
        display: block;
    }
    
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 15px;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-secondary {
        background-color: #f1f5f9;
        color: #000; /* Cambiado a negro */
        border: none;
    }
    
    .btn-secondary:hover {
        background-color: #e2e8f0;
    }
    
    .btn-info {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: white;
    }
    
    .btn-info:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
    
    /* Reduzca el tamaño de textarea */
    textarea.form-control {
        height: 80px;
        resize: vertical;
    }
    
    /* Ajuste móvil */
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
    }
</style>

<div class="container">
    <div class="vehicle-form-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                <b>Editar registro de vehículo</b>
            </h3>
            <div class="action-buttons d-flex gap-2">
                <a href="javascript:window.history.back();" class="btn btn-secondary btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" form="vehicle-form" class="btn btn-info btn-icon">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('registrovehicular.update', $registro->id) }}" id="vehicle-form">
                @csrf 
                @method('PUT')

                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="equipo">Equipo <span class="text-danger"> *</span></label>
                        <input type="text" id="equipo" name="equipo" 
                               class="form-control form-control-lg @error('equipo') is-invalid @enderror" 
                               value="{{ old('equipo', $registro->equipo) }}" maxlength="20" required>
                        @error('equipo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="placa">Placa</label>
                        <input type="text" id="placa" name="placa" 
                               class="form-control form-control-lg @error('placa') is-invalid @enderror" 
                               value="{{ old('placa', $registro->placa) }}" oninput="formatPlaca(this)" 
                               placeholder="Ej: ABC 1234">
                        @error('placa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="motor">Motor</label>
                        <input type="text" id="motor" name="motor" 
                               class="form-control form-control-lg @error('motor') is-invalid @enderror" 
                               value="{{ old('motor', $registro->motor) }}" maxlength="35">
                        @error('motor')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="marca">Marca</label>
                        <input type="text" id="marca" name="marca" 
                               class="form-control form-control-lg @error('marca') is-invalid @enderror" 
                               value="{{ old('marca', $registro->marca) }}" maxlength="25">
                        @error('marca')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo" 
                               class="form-control form-control-lg @error('modelo') is-invalid @enderror" 
                               value="{{ old('modelo', $registro->modelo) }}" maxlength="30">
                        @error('modelo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="serie">Serie</label>
                        <input type="text" id="serie" name="serie" 
                               class="form-control form-control-lg @error('serie') is-invalid @enderror" 
                               value="{{ old('serie', $registro->serie) }}" maxlength="25">
                        @error('serie')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="asignado">Asignado <span class="text-danger"> *</span></label>
                        <input type="text" id="asignado" name="asignado" 
                               class="form-control form-control-lg @error('asignado') is-invalid @enderror" 
                               value="{{ old('asignado', $registro->asignado) }}" maxlength="30" required>
                        @error('asignado')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="observacion">Observación</label>
                        <textarea id="observacion" name="observacion" 
                                  class="form-control form-control-lg @error('observacion') is-invalid @enderror" 
                                  rows="3" maxlength="40">{{ old('observacion', $registro->observacion) }}</textarea>
                        @error('observacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
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

@endsection
