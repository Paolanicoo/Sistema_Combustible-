
@extends('Layouts.LayoutPrincipal')

@section('titulo', 'Editar Vehículo')

@section('contenido')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <h4 class="centered-title">Editar Registro de Vehículo</h4>
    <form method="post" action="{{ route('registrovehicular.update', $registro->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="equipo">Equipo:</label>
                <input type="text" name="equipo" value="{{ $registro->equipo }}"required>

                @error('equipo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" class="form-control" value="{{ old('placa', $registro->placa) }}" required oninput="formatPlaca(this)">
                @error('placa')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="motor">Motor:</label>
                <input type="text" id="motor" name="motor" class="form-control" value="{{ old('motor', $registro->motor) }}" maxlength="35" required>
                @error('motor')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca', $registro->marca) }}" maxlength="25" required>
                @error('marca')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value="{{ old('modelo', $registro->modelo) }}" maxlength="30" required>
                @error('modelo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="serie">Serie:</label>
                <input type="text" id="serie" name="serie" class="form-control" value="{{ old('serie', $registro->serie) }}" maxlength="25" required>
                @error('serie')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="asignado">Asignado:</label>
                <input type="text" id="asignado" name="asignado" class="form-control" value="{{ old('asignado', $registro->asignado) }}" maxlength="30" required>
                @error('asignado')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="40">{{ old('observacion', $registro->observacion) }}</textarea>
                @error('observacion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-custom">Actualizar registro</button>
    </form>
</div>

<!-- Formateo de la placa -->
<script>
    function formatPlaca(input) {
        let value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, ""); // Solo letras y números

        if (value.length > 3) {
            value = value.substring(0, 3) + " " + value.substring(3);
        }

        if (value.length > 8) {
            value = value.substring(0, 8);
        }

        input.value = value;
    }
</script>

@endsection
