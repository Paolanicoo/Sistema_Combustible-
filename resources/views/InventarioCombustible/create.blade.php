@extends('Layouts.app')

@section('titulo', 'Registro de Combustible')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

<style>
    /* Estilos generales */
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    .card {
        border-radius: 10px;
        max-width: 900px;
        margin-top: 50px;
        margin-left: auto;
        margin-right: auto;
        background-color: #f9f9f9;
        padding: 50px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        min-height: 450px;
        height: auto;
    }

    .card-header {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 24px;
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: bold;
    }

    .form-control, .btn {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #66afe9;
        outline: none;
    }

    .btn-custom {
        background-color: rgb(53, 192, 88);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        width: 100%;
        border: none;
    }

    .btn-custom:hover {
        background-color: rgb(40, 160, 70);
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

    /* Nuevos estilos para reorganizar los campos */
    .form-group-expanded {
        margin-bottom: 2rem;
    }

    .form-control-expanded {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
</style>

<div class="card p-4">
    <form method="post" action="{{ route('combustible.store') }}" id="combustibleForm">
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="centered-title m-0"><i class="fas fa-oil-can mr-2"></i> Registro inicial de combustible</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('combus.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
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
        <div class="form-group-expanded">
            <label class="form-label" for="descripcion">Descripción detallada:</label>
            <textarea id="descripcion" name="descripcion" 
                      class="form-control form-control-expanded" 
                      required rows="4"
                      placeholder="Detalles como tipo de combustible, proveedor, ubicación, etc."></textarea>
            @error('descripcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </form>
</div>
@endsection