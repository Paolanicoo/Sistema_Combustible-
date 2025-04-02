@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

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
    
    .centered-title { 
        color: #344767;
        font-weight: 530;
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
        margin-bottom: 6px;
        font-weight: 600; /* Más negrita */
        color: #344767; /* Color más oscuro */
        font-size: 1rem !important; /* 16px - Tamaño aumentado */
        letter-spacing: 0.3px;
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
        <div class="card-header position-relative d-flex justify-content-end" style="min-height: 60px;">
            <!-- Título perfectamente centrado -->
            <h3 class="centered-title m-0 position-absolute start-50 translate-middle-x" style="transform: translateX(-50%); white-space: nowrap;">
                <b>Registro vehicular</b>
            </h3>
            
            <!-- Botones alineados a la derecha -->
            <div class="action-buttons d-flex gap-2">
                <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" form="vehicle-form" class="btn btn-info d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <form method="post" action="{{ route('registrovehicular.store') }}" id="vehicle-form">
                @csrf 
                
                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="equipo">Equipo <span class="text-danger"> *</span></label>
                        <input type="text" id="equipo" name="equipo" 
                               class="form-control form-control-lg @error('equipo') is-invalid @enderror" 
                               value="{{ old('equipo') }}" maxlength="20">
                        @error('equipo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="placa">Placa</label>
                        <input type="text" id="placa" name="placa" 
                               class="form-control form-control-lg @error('placa') is-invalid @enderror" 
                               value="{{ old('placa') }}" oninput="formatPlaca(this)" 
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
                               value="{{ old('motor') }}" maxlength="35">
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="marca">Marca</label>
                        <input type="text" id="marca" name="marca" 
                               class="form-control form-control-lg @error('marca') is-invalid @enderror" 
                               value="{{ old('marca') }}" maxlength="25">
                    </div>
                </div>
                
                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo" 
                               class="form-control form-control-lg @error('modelo') is-invalid @enderror" 
                               value="{{ old('modelo') }}" maxlength="30">
                    </div>

                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="serie">Serie</label>
                        <input type="text" id="serie" name="serie" 
                               class="form-control form-control-lg @error('serie') is-invalid @enderror" 
                               value="{{ old('serie') }}" maxlength="25">
                        @error('observacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row d-flex flex-wrap gap-3">
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="asignado">Asignado <span class="text-danger"> *</span></label>
                        <input type="text" id="asignado" name="asignado" 
                               class="form-control form-control-lg @error('asignado') is-invalid @enderror" 
                               value="{{ old('asignado') }}" maxlength="30">
                    </div>
                    <div class="form-group flex-grow-1">
                        <label class="form-label fw-bold fs-6" for="observacion">Observación</label>
                        <textarea id="observacion" name="observacion" 
                                  class="form-control form-control-lg @error('observacion') is-invalid @enderror" 
                                  rows="3" maxlength="40">{{ old('observacion') }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Formateo de la placa -->
<script>
    function formatPlaca(input) {
        let value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, "");
        
        // Evitar que inicie con números
        if (value.length > 0 && !isNaN(value[0])) {
            value = value.substring(1);
        }
        
        // Formatea como XXX 1234
        if (value.length > 0) {
            // Separa letras y números
            const letters = value.replace(/[0-9]/g, "").slice(0, 3);
            const numbers = value.replace(/[A-Z]/g, "").slice(0, 4);
            
            // Reconstruye con el formato adecuado
            if (letters && numbers) {
                value = `${letters} ${numbers}`;
            } else if (letters) {
                value = letters;
            }
        }
        
        input.value = value;
    }
</script>
@endsection