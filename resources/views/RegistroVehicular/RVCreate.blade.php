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


<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Registro de Vehículo</h2>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('registrovehicular.store')}}">
                @csrf {{--muy importente poner siempre en el formulario de crear y editar--}}
                
                <div class="mb-3">
                    <label class="form-label">Equipo:</label>
                    <input type="text" id="equipo" name="equipo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Placa:</label>
                    <input type="text" id="placa" name="placa" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Motor:</label>
                    <input type="text" id="motor" name="motor" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Serie:</label>
                    <input type="text" id="serie" name="serie" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Asignado:</label>
                    <input type="text" id="asiganado" name="asignado" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observación:</label>
                    <textarea id="observasion" name="observacion" class="form-control" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-success w-100">Guardar Registro</button>
            </form>
        </div>
    </div>
</div>
@endsection