@extends('Layouts.app')

@section('titulo', 'Registro de Combustible')

@section('contenido')
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

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .col-md-6 {
        flex: 1 1 48%;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
</style>

<div class="card p-4">
    <form method="post" action="{{ route('combustible.store') }}">
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="centered-title m-0">Registro inicial de combustible</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('combus.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="cantidad_entrada">Cantidad inicial (galones):</label>
                <input type="number" step="0.01" id="cantidad_entrada" name="cantidad_entrada" 
                       class="form-control" required oninput="validarNumeroDecimal(this)">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            </div>
        </div>
    </form>
</div>

<script>
    function validarNumeroDecimal(input) {
        input.value = input.value.replace(/[^0-9.]/g, ''); // Permite números y un solo punto
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.replace(/\.+$/, ""); // Evita múltiples puntos decimales
        }
    }

    // Establecer fecha actual
    window.onload = function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        
        // Si necesitas un campo de fecha
        if(document.getElementById('fecha')) {
            document.getElementById('fecha').value = today;
        }
    }
</script>

@endsection