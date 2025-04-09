@extends('Layouts.app')

@section('titulo','Crear Vehiculo')

@section('contenido')

@include('sweetalert::alert')

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
        max-width: 700px;
    }
    
    .card-body {
        padding: 1.5rem;
        background-color: #fff;
        margin-top: -10px; /* Reduce el margen superior para acercar el formulario al título */
    }

    /* Form layout - más compacto */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: -8px;
        margin-bottom: 0.25rem; /* Reduce el margen inferior */
    }

    .form-group {
        flex: 1 1 calc(50% - 16px);
        min-width: 250px;
        padding: 8px;
        margin-bottom: 0.25rem; /* Reduce el margen inferior */
    }

    /* LABELS - más compactos */
    .form-label {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
        color: #344767;
        font-size: 0.95rem !important;
        letter-spacing: 0.3px;
    }

    /* INPUTS - Tamaño reducido */
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
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
        font-size: 0.75rem;
        margin-top: 2px;
        display: block;
    }
    
    /* Área de texto más pequeña */
    textarea.form-control {
        height: 80px;
        resize: vertical;
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
        color: #344767;
    }

    .btn-custom:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: white;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
    
    /* Footer para botones */
    .d-flex {
        display: flex;
    }
    
    .justify-content-end {
        justify-content: flex-end;
    }
    
    .gap-3 {
        gap: 0.75rem;
    }
    
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
    }
</style>

<div class="card p-4">
    <form method="post" action="{{ route('registrovehicular.store') }}" id="vehicle-form">
        @csrf

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Registro vehicular</h3>
        </div>

        <div class="card-body">
            <!-- Primera fila: Equipo y Placa -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="equipo">Equipo</label>
                    <input type="text" id="equipo" name="equipo" 
                           class="form-control @error('equipo') is-invalid @enderror" 
                           value="{{ old('equipo') }}" maxlength="20">
                    @error('equipo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="placa">Placa</label>
                    <input type="text" id="placa" name="placa" 
                           class="form-control @error('placa') is-invalid @enderror" 
                           value="{{ old('placa') }}" oninput="formatPlaca(this)" 
                           placeholder="Ej: ABC 1234">
                    @error('placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Segunda fila: Motor y Marca -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="motor">Motor</label>
                    <input type="text" id="motor" name="motor" 
                           class="form-control @error('motor') is-invalid @enderror" 
                           value="{{ old('motor') }}" maxlength="35">
                    @error('motor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" 
                           class="form-control @error('marca') is-invalid @enderror" 
                           value="{{ old('marca') }}" maxlength="25">
                    @error('marca')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Tercera fila: Modelo y Serie -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" 
                           class="form-control @error('modelo') is-invalid @enderror" 
                           value="{{ old('modelo') }}" maxlength="30">
                    @error('modelo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="serie">Serie</label>
                    <input type="text" id="serie" name="serie" 
                           class="form-control @error('serie') is-invalid @enderror" 
                           value="{{ old('serie') }}" maxlength="25">
                    @error('serie')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Cuarta fila: Asignado y Observación -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="asignado">Asignado</label>
                    <input type="text" id="asignado" name="asignado" 
                           class="form-control @error('asignado') is-invalid @enderror" 
                           value="{{ old('asignado') }}" maxlength="30">
                    @error('asignado')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="observacion">Observación</label>
                    <textarea id="observacion" name="observacion" 
                              class="form-control @error('observacion') is-invalid @enderror" 
                              maxlength="60">{{ old('observacion') }}</textarea>
                    @error('observacion')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones alineados a la derecha -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('registrovehicular.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </form>
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