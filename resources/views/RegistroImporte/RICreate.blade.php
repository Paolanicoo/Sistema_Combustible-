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
            <h2>Resumen Importe</h2>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('registroimporte.store')}}">
                @csrf {{--muy importente poner siempre en el formulario de crear y editar--}}

                <div class="mb-3">
                    <label class="form-label">Fecha:</label>
                    <input type="date" name="fecha" class="form-control"  required>
                </div>
                
                <div class="mb-3">
        <label>Seleccionar Vehículo:</label>

        <select id="vehiculoSelect" name="id_registro_vehicular" class="form-control" required>
            <option value="">Seleccione un vehículo</option>
            @foreach($vehiculos as $vehiculo)
                <option value="{{ $vehiculo->id }}" 
                    data-equipo="{{ $vehiculo->equipo }}" 
                    data-placa="{{ $vehiculo->placa }}"
                    data-marca="{{ $vehiculo->marca }}"
                    data-asignado="{{ $vehiculo->asignado }}">
                    {{ $vehiculo->equipo }} - {{ $vehiculo->marca }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Equipo:</label>
        <input type="text" id="equipo" name="equipo" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label>Placa:</label>
        <input type="text" id="placa" name="placa" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label>Marca:</label>
        <input type="text" id="marca" name="marca" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label>Asignado:</label>
        <input type="text" id="asignado" name="asignado" class="form-control" readonly>
    </div>

<div class="mb-3">
    <label>Seleccionar Registro de combustible:</label>

    <select id="combustibleSelect" name="id_registro_combustible" class="form-control" required>
        <option value="">Seleccione un registro de combustible</option>
        @if(isset($combustibles) && $combustibles->count() > 0)
            @foreach($combustibles as $combustible)
       
            <option value="{{ $combustible->id }}" 
                data-fecha="{{ $combustible->fecha }}" 
                data-numfac="{{ $combustible->num_factura }}" 
                data-precio="{{ $combustible->precio }}"
                data-consumo="{{ $combustible->salidas }}">
                {{ $combustible->num_factura }}
            </option>
            @endforeach
        <option value="">No hay registros de combustible</option>
    @endif
</select> 
</div>
                
                <div class="mb-3">
                <label>N de factura:</label>
                <input type="number" id="numfac" name="numfac" class="form-control"  readonly >

                </div>
            
                <div class="mb-3">
                    <label class="form-label">Consumo:</label>
                    <input type="number" id="salidas" name="salidas" class="form-control" step="0.01" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio:</label>
                    <input type="number" id="precio" name="precio" class="form-control" step="0.01"  readonly >
                </div>

                <div class="mb-3">
                    <label class="form-label">Total:</label>
                    <input type="number" id="total" name="total" class="form-control" step="0.01"  required >
                </div>

                <div class="mb-3">
                <label for="empresa">Empresa:</label>
                <select id= "empresa" name="empresa" class="form-control">
                <option value="">Seleccione una opción</option>
                <option value="Taosa">TAOSA</option>
                <option value="Clasificadora">Clasificadora</option>
                <option value="Francisco Gusman">Francisco Gusman</option>
            </select>
                </div>
                
                <div class="mb-3">
    <label for="tipo">Tipo:</label>
    <select id= "cog" name="cog" class="form-control">
        <option value="">Seleccione una opción</option>
        <option value="costo">Costo</option>
        <option value="gasto">Gasto</option>
    </select>
</div>
                
                <button type="submit" class="btn btn-success w-100">Guardar Registro</button>
            </form>


            <script>
    // Cuando se seleccione un vehículo, llena los campos relacionados
    document.getElementById('vehiculoSelect').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    
    document.getElementById('equipo').value = selectedOption.getAttribute('data-equipo');
    document.getElementById('placa').value = selectedOption.getAttribute('data-placa');
    document.getElementById('marca').value = selectedOption.getAttribute('data-marca');
    document.getElementById('asignado').value = selectedOption.getAttribute('data-asignado');
});

    // Cuando se seleccione un combustible, llena los campos relacionados
    document.getElementById('combustibleSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];

        document.getElementById('numfac').value = selectedOption.getAttribute('data-numfac') || '';
        document.getElementById('salidas').value = selectedOption.getAttribute('data-consumo') || '';
        document.getElementById('precio').value = selectedOption.getAttribute('data-precio') || '';
    });


    if (combustibleSelect) {
            combustibleSelect.addEventListener('change', function () {
                let selectedOption = this.options[this.selectedIndex];

        // Obtener valores desde los atributos del option
        let consumo = parseFloat(selectedOption.getAttribute('data-consumo')) || 0;
        let precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
        let total = consumo * precio;

                // Rellenamos los campos
                consumoInput = document.getElementById('salidas');
                let precioInput = document.getElementById("precio");
                precioInput.value = precio;
                let totalInput = document.getElementById("total");
                totalInput.value = total.toFixed(2); // Redondear a 2 decimales

                console.log(" Datos actualizados → Consumo:", consumo, "Precio:", precio, "Total:", total);
            });
    };
</script>

        </div>
    </div>
</body>
</html>



@endsection