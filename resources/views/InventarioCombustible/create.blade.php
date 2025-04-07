@extends('Layouts.app')

@section('titulo', 'Registro de Combustible')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
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
        min-height: 300px;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .centered-title {
        color: #344767;
        font-weight: 600;
        font-size: 1.5rem;
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
        margin-bottom: 8px;
        font-weight: 600;
        color: #344767;
        font-size: 1.05rem !important;
        letter-spacing: 0.3px;
    }

    /* INPUTS - Tamaño consistente */
    .form-control {
        width: 100%;
        padding: 12px 15px;
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
    
    .text-danger {
        color: #dc3545;
        font-size: 0.8125rem;
        margin-top: 4px;
        display: block;
    }
    
    /* Botones */
    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
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
        color: #344767; /* Mismo color que el de Regresar */
    }

    .btn-custom:hover {
        background-color: #0284c7;
        border-color: #0284c7;
        color: white; /* Texto blanco al pasar el mouse */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        transform: translateY(-2px);
    }
    
    /* Área de texto más grande */
    textarea.form-control {
        height: 115px;
        resize: vertical;
    }
    
    /* Footer para botones */
    .form-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding: 0 1.5rem 1.5rem;
    }
    
    .btn-icon {
        width: auto;
        height: auto;
        padding: 0.6rem 1.2rem;
    }
    
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
        
        .form-footer {
            flex-direction: column;
            gap: 10px;
        }
        
        .btn {
            width: 100%;
        }
    }
    
    /* Espacio entre campos */
    .form-group-expanded {
        margin-bottom: 1.5rem;
    }
</style>

<div class="card p-4">
    <form method="post" action="{{ route('combustible.store') }}" id="combustibleForm">
        @csrf

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h3 class="m-0">Registro inicial de combustible</h3>
        </div>

        <!-- Aquí empieza tu card-body y formulario -->
        <div class="card-body">
            <!-- Campo de cantidad inicial -->
            <div class="form-group-expanded mb-4">
                <label class="form-label" for="cantidad_entrada">Cantidad inicial (galones):</label>
                <input type="number" step="0.01" id="cantidad_entrada" name="cantidad_entrada" 
                    class="form-control form-control-expanded" required 
                    oninput="validarNumeroDecimal(this)"
                    placeholder="Ej. 150.75">
                @error('cantidad_entrada')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de descripción expandido -->
            <div class="form-group-expanded mb-4">
                <label class="form-label" for="descripcion">Descripción detallada:</label>
                <textarea id="descripcion" name="descripcion" 
                        class="form-control form-control-expanded" 
                        required rows="6"
                        placeholder="Detalles como tipo de combustible, proveedor, ubicación, etc."></textarea>
                @error('descripcion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Botones alineados a la derecha -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('combus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection