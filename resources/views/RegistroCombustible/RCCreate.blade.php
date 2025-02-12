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
            <form method="post" action="{{route('registrocombustible.store')}}">
                @csrf {{--muy importente poner siempre en el formulario de crear y editar--}}


                <div class="mb-3">
                    <label class="form-label">Fecha:</label>
                    <input type="date" name="fecha" class="form-control"  required>
                </div>
                
                <div class="mb-3">
                <label>Equipo:</label>
                <input type="text" name="equipo" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Placa:</label>
                <input type="text" name="placa" class="form-control" pattern="[A-Za-z0-9 ]+"  required>
                </div>
                
                <div class="mb-3">
                <label>Marca:</label>
                <input type="text" name="marca" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>Asignado:</label>
                <input type="text" name="asignado" class="form-control"  required>
                </div>

                <div class="mb-3">
                <label>N de factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control"  required >

                </div>
            
                <div class="mb-3">
                    <label class="form-label">Entrada Galones:</label>
                    <input type="number" id="engalones" name="engalones" class="form-control" step="0.01" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Salida Galones:</label>
                    <input type="number" id="sagalones" name="sagalones" class="form-control" step="0.01"  required >
                </div>
                
                
                <button type="submit" class="btn btn-success w-100">Guardar Registro</button>
            </form>
        </div>
    </div>
</body>
</html>
@endsection
