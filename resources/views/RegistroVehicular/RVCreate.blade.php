@extends('Layouts.LayoutPrincipal')

@section('titulo','Crear Vehiculo')

@section('contenido')

@if ($errors->any())     {{--ESTA ES LA ALERTA DE LAS VALIDACIONES--}}


    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <style>
        
        .header {
            background-color: #333; 
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 10px;
            max-width: 700px;
            margin-top: 30px; /* Subir el formulario un poco */
            margin-left: auto;
            margin-right: auto;
        }
        .card-header {
            background-color:rgba(253, 254, 255, 0.98); 
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: black; /* Letras en negro */
            text-align: center;
            padding: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control, .btn {
            border-radius: 8px;
        }
        .btn-custom {
            background-color:rgb(53, 192, 88);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            width: 100%;
        } 
    </style>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Registro de vehículo</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('registrovehicular.store') }}">
                    @csrf  {{-- Muy importante para los formularios de creación y edición --}}
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="equipo">Equipo:</label>
                            <input type="text" id="equipo" name="equipo" class="form-control" value="{{ old('equipo') }}" maxlength="20" required>
                            @error('equipo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="placa">Placa:</label>
                            <input 
                                type="text" 
                                id="placa" 
                                name="placa" 
                                class="form-control" 
                                value="{{ old('placa') }}" 
                                required
                                oninput="formatPlaca(this)" 
                                placeholder="Ej: ABC 1234">
                            @error('placa')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="motor">Motor:</label>
                            <input type="text" id="motor" name="motor" class="form-control" value="{{ old('motor') }}" maxlength="35" required>
                            @error('motor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="marca">Marca:</label>
                            <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca') }}" maxlength="25" required>
                            @error('marca')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="modelo">Modelo:</label>
                            <input type="text" id="modelo" name="modelo" class="form-control" value="{{ old('modelo') }}" maxlength="30" required>
                            @error('modelo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="serie">Serie:</label>
                            <input type="text" id="serie" name="serie" class="form-control" value="{{ old('serie') }}" maxlength="25" required>
                            @error('serie')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="asignado">Asignado:</label>
                            <input type="text" id="asignado" name="asignado" class="form-control" value="{{ old('asignado') }}" maxlength="30" required>
                            @error('asignado')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="observacion">Observación:</label>
                            <textarea id="observacion" name="observacion" class="form-control" rows="3" maxlength="40">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-custom">Guardar Registro</button>
                </form>
            </div>
        </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>



@endsection
