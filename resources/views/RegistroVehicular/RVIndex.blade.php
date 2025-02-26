@extends('Layouts.app')

@section('titulo','index')

@section('contenido')

    <style>
                /* Contenedor para título y botón alineados a la derecha */
        .d-flex {
            display: flex;
            justify-content: space-between; /* Alinea el título y el botón con el máximo espacio posible */
            align-items: center; /* Alinea verticalmente los elementos */
        }

        .mb-4 {
            margin-bottom: 1rem; /* Ajuste de espacio entre el título, botón y la tabla */
        }


            /* Ajustar la columna de "Acciones" para mayor espacio */
        .fixed-table th:nth-child(9), .fixed-table td:nth-child(9) {
            width: 160px; /* Aumenta el ancho de la columna según sea necesario */
        }

        /* Ajuste de los botones en la celda de acciones */
        .action-buttons {
            display: flex;
            justify-content: space-between; /* Alineación horizontal de los botones con espacio entre ellos */
            gap: 1px; /* Espacio entre los botones */
        }

        button {
            white-space: nowrap; /* Evita que los textos se partan en los botones */
            padding: 8px 10px; /* Ajusta el tamaño del botón */
            font-size: 8px; /* Ajusta el tamaño del texto del botón */
        }


        .table-container {
            max-height: 400px; /* Puedes ajustar el valor según el tamaño que desees */
        }

        .fixed-table {
            width: 100%; /* Asegura que la tabla ocupe el 100% del contenedor */
            table-layout: fixed; /* Esto ayuda a que las columnas no se expandan */
        }

        .fixed-table th, .fixed-table td {
            word-wrap: break-word; /* Hace que los textos largos no se desborden y se ajusten dentro de la celda */
            overflow: hidden;
        }

        td {
            vertical-align: middle; /* Alinea verticalmente el contenido de las celdas */
        }

        .observacion-cell {
            max-width: 250px; /* Limita el ancho de la columna de observación */
            overflow: hidden;
        }


    </style>

    <!-- Creacion de tabla -->
    <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><b>Registro vehicular</b></h2>
        <!-- Botón para nuevo registro alineado a la derecha -->
        <a href="{{route('registrovehicular.create')}}" class="btn btn-success">Agregar nuevo</a>
    </div>
        <div class="table-container">
            <table class="table table-striped table-bordered fixed-table">
                <thead class="table-dark">
                    <tr>
                        <th>Equipo</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Motor</th>
                        <th>Serie</th>
                        <th>Asignado</th>
                        <th>Observación</th>
                        <th>Acciones</th>
                    </tr>

                </thead>
                <tbody>
                @foreach ($registros as $registro)
                    <tr>
                        <td>{{$registro->equipo}}</td>
                        <td>{{$registro->marca}}</td>
                        <td>{{$registro->placa}}</td>
                        <td>{{$registro->modelo}}</td>
                        <td>{{$registro->motor}}</td>
                        <td>{{$registro->serie}}</td>
                        <td>{{$registro->asignado}}</td>
                        <td class="observacion-cell">{{$registro->observacion}}</td>
                        <td>
                            <div class="action-buttons">
                            <a href="{{ route('registrovehicular.RVEdit', $registro->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('registrovehicular.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
                            </div>
                        </td>
                        
                    </tr>
                    
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>


{{ $registros->render('pagination::bootstrap-4') }}

@endsection()
