@extends('Layouts.app')

@section('titulo', 'Registro de Salida de Combustible')

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
        min-height: 500px;
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

    /* Área de texto más pequeña para la descripción */
    textarea.form-control {
        height: 120px;
        resize: vertical;
    }

    /* Footer para botones */
    .form-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding: 0 1.5rem 1.5rem;
    }

    /* Espacio entre campos */
    .form-group-expanded {
        margin-bottom: 1.5rem;
    }
</style>

<div class="card p-4">
    <form method="POST" action="{{ route('combus.update', $combustible->id) }}" id="salidaCombustibleForm">
        @csrf
        @method('PUT')

        <!-- Título centrado con fondo gris claro -->
        <div class="text-center mb-5" style="background-color: #f0f0f0; color: #344767; padding: 15px; border-radius: 8px;">
            <h4 class="m-0">Registro de salida de combustible</h4>
        </div>

        <!-- Primera fila -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <label for="cantidad_actual" class="form-label">Cantidad actual (galones):</label>
                <input type="number" id="cantidad_actual" value="{{ $combustible->cantidad_actual }}" class="form-control" disabled>
            </div>

            <div class="col-md-6 mb-4">
                <label for="cantidad_retirada" class="form-label">Cantidad a retirar:</label>
                <input type="number" step="0.01" name="cantidad_retirada" id="cantidad_retirada" class="form-control"  oninput="validarNumeroDecimal(this)">
                @error('cantidad_retirada')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <label for="persona" class="form-label">Persona que retira:</label>
                <input type="text" name="persona" id="persona" class="form-control" maxlength="30">
                @error('persona')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
                @error('fecha')
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

    // Manejo del formulario con SweetAlert
    document.getElementById('salidaCombustibleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const cantidadActual = parseFloat(document.getElementById('cantidad_actual').value);
        const cantidadRetirada = parseFloat(document.getElementById('cantidad_retirada').value);
        const persona = document.getElementById('persona').value;
        
        if (!cantidadRetirada || !persona) {
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Por favor complete todos los campos requeridos',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        if (cantidadRetirada > cantidadActual) {
            Swal.fire({
                icon: 'error',
                title: 'Cantidad no disponible',
                text: 'No hay suficiente combustible disponible para retirar',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        Swal.fire({
            title: '¿Confirmar salida de combustible?',
            html: `<p>Va a registrar la salida de <strong>${cantidadRetirada} galones</strong></p>
                  <p>Persona que retira: <strong>${persona}</strong></p>
                  <p>Saldo restante: <strong>${(cantidadActual - cantidadRetirada).toFixed(2)} galones</strong></p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, registrar salida',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si confirma, enviar el formulario
                e.target.submit();
            }
        });
    });
</script>
@endsection