@extends('Layouts.app')

@section('titulo', 'Registro de Salida de Combustible')

@section('contenido')
<style>
    /* Estilos generales */
    body {
        background-color: #f9f9f9;
        font-family: 'Arial', sans-serif;
    }

    /* Estilos para los campos deshabilitados */
    .form-control[readonly], .form-control[disabled] {
        background-color: #f0f0f0;
        color: #888;
        cursor: not-allowed;
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

    /* Estilo de los campos de formulario */
    .form-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .col-md-6 {
        flex: 1 1 48%;
    }

    .col-md-3 {
        flex: 1 1 23%;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    textarea.form-control {
        resize: vertical;
    }
</style>

<div class="card p-4">
    <form method="POST" action="{{ route('combus.update', $combustible->id) }}">
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Registro de salida de combustible</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('combus.index') }}" class="btn btn-secondary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn btn-custom d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="cantidad_actual">Cantidad actual (galones):</label>
                <input type="number" id="cantidad_actual" value="{{ $combustible->cantidad }}" class="form-control" disabled>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="cantidad_retirada">Cantidad a retirar:</label>
                <input type="number" step="0.01" name="cantidad_retirada" id="cantidad_retirada" class="form-control" required oninput="validarNumeroDecimal(this)">
                @error('cantidad_retirada')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="persona">Persona que retira:</label>
                <input type="text" name="persona" id="persona" class="form-control" required>
                @error('persona')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
                @error('fecha')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </form>
</div>

<script>
    function validarNumeroDecimal(input) {
        input.value = input.value.replace(/[^0-9.]/g, '');
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, "");
        }
    }

    // Establecer fecha actual
    window.onload = function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        
        document.getElementById('fecha').value = today;
    }
</script>
@endsection