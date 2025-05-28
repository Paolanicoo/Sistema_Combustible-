@extends('Layouts.app') {{-- Hereda la plantilla principal del sistema --}}

@section('titulo', 'Registro de Combustible') {{-- Define el título que se usará en la vista --}}

@section('contenido') {{-- Inicia la sección de contenido principal --}}

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<style>  
    /* Estilos base */
    body {
        font-family: 'Poppins', sans-serif; /* Fuente moderna y legible */
        background-color: #f8f9fa; /* Color de fondo gris claro*/
        color: #000;/* Texto negro*/
        font-size: 15px;/*Tamaño estándar de fuente  */
    }

    .card { /* Estilo de la tarjeta principal que contiene el formulario */
        border-radius: 12px;/*Bordes redondeados */
        border: none;/* Sin borde por defecto*/
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);/*Sombra suave */
        overflow: hidden;/* Oculta contenido desbordado*/
        margin: 50px auto;/*Margen superior y centrado horizontalmente  */
        max-width: 700px;/* Ancho máximo*/
        min-height: 300px;/*Altura mínima */
    }
    
    .card-header {  /* Encabezado de la tarjeta */
        background-color: #fff; /* Fondo blanco */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Línea divisoria inferior */
        padding: 1.5rem; /* Espaciado interno */
        display: flex; /* Flexbox para alineación */
        justify-content: center; /* Centra horizontalmente */
        align-items: center;  /* Centra verticalmente */
    }

    .centered-title { /* Título centrado y estilizado */
       color: #344767; /* Color azul oscuro */
        font-weight: 600; /* Negrita */
        font-size: 1.5rem; /* Tamaño grande */
        margin-bottom: 0; /* Sin margen inferior */
        text-align: center; /* Centrado */
    }
    
    .card-body { /* Cuerpo de la tarjeta */
        padding: 1.5rem; /* Espaciado interno */
        background-color: #fff; /* Fondo blanco */
    }

    /* Etiquetas de los campos del formulario */
    .form-label {
       display: block; /* Ocupa toda la línea */
        margin-bottom: 8px; /* Espacio inferior */
        font-weight: 600; /* Negrita */
        color: #344767; /* Color azul oscuro */
        font-size: 1.05rem !important; /* Tamaño ligeramente mayor */
        letter-spacing: 0.3px; /* Espaciado entre letras */
    }

    /* Campos de entrada del formulario */
    .form-control {
       width: 100%; /* Ocupa todo el ancho */
        padding: 12px 15px; /* Espaciado interno */
        border: 1px solid #e2e8f0; /* Borde gris claro */
        border-radius: 8px; /* Bordes redondeados */
        font-size: 0.9375rem; /* Tamaño de fuente */
        transition: all 0.3s ease; /* Transición suave */
        color: #344767; /* Color del texto */
    }
    
    .form-control:focus {  /* Efecto al enfocar el campo */
        border-color: #0ea5e9; /* Borde azul */
        outline: none; /* Sin contorno extra */
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25); /* Sombra azul */
    }
    /* Campo inválido (con error) */
    .form-control.is-invalid {
        border-color: #dc3545; /* Borde rojo */
    }
     /* Texto de error */
    .text-danger {
        color: #dc3545; /* Rojo */
        font-size: 0.8125rem; /* Tamaño pequeño */
        margin-top: 4px; /* Espacio superior */
        display: block; /* Ocupa toda la línea */
    }
    
    /* Botones */
    .btn {
        padding: 0.6rem 1.2rem; /* Espaciado interno */
        border-radius: 8px; /* Bordes redondeados */
        font-weight: 600; /* Negrita */
        font-size: 0.95rem; /* Tamaño de fuente */
        transition: all 0.3s ease; /* Transición suave */
        display: flex; /* Flexbox */
        align-items: center; /* Centrado vertical */
        justify-content: center; /* Centrado horizontal */
        gap: 8px; /* Espacio entre íconos y texto */
    }
    /* Botón secundario (Regresar) */
    .btn-secondary {
        background-color: #f1f5f9; /* Fondo gris claro */
        color: #344767; /* Texto azul oscuro */
        border: none; /* Sin borde */
    }
    /* Efecto hover en botón secundario */
    .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }
    /* Botón personalizado (Guardar) */
    .btn-custom {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
        color: #344767; /* Mismo color que el de Regresar */
    }
      /* Efecto hover en botón personalizado */
    .btn-custom:hover {
        background-color: #0284c7; /* Azul más oscuro */
        border-color: #0284c7; /* Borde azul más oscuro */
        color: white; /* Texto blanco */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra azul */
        transform: translateY(-2px); /* Efecto de elevación */
    }
    
    /* Área de texto más grande */
    textarea.form-control {
        height: 115px; /* Altura fija */
        resize: vertical; /* Permite cambiar altura */
    }
    
    /* Footer para botones */
    .form-footer {
        display: flex; /* Flexbox */
        justify-content: space-between; /* Espaciado entre botones */
        margin-top: 2rem; /* Espacio superior */
        padding: 0 1.5rem 1.5rem; /* Espaciado interno */
    }
    /* Botón con ícono */
    .btn-icon {
        width: auto;
        height: auto;
        padding: 0.6rem 1.2rem;
    }
    /* Adaptación para pantallas pequeñas */
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
        
        .form-footer {
            flex-direction: column; /* Botones uno debajo del otro */
            gap: 10px; /* Espacio entre botones */
        }
        
        .btn {
            width: 100%; /* Botones ocupan todo el ancho */
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

        <div class="row mb-4">
            <!-- Campo de fecha -->
            <div class="col-md-6">
                <label class="form-label" for="fecha">Fecha de entrada:</label>
                <input type="date" id="fecha" name="fecha" 
                    class="form-control" required 
                    value="{{ old('fecha') ? old('fecha') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                @error('fecha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de cantidad -->
            <div class="col-md-6">
                <label class="form-label" for="cantidad_entrada">Cantidad inicial (galones):</label>
                <input type="number" step="0.01" id="cantidad_entrada" name="cantidad_entrada" 
                    class="form-control" required 
                    oninput="validarNumeroDecimal(this)"
                    placeholder="Ej. 150.75">
                @error('cantidad_entrada')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Campo de descripción expandido -->
        <div class="form-group-expanded mb-4">
            <label class="form-label" for="descripcion">Descripción detallada:</label>
            <textarea id="descripcion" name="descripcion" 
                    class="form-control form-control-expanded" 
                    rows="6"
                    placeholder="Detalles como tipo de combustible, proveedor, ubicación, etc." maxlength="100"></textarea>
            @error('descripcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
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