@extends('Layouts.LayoutPrincipal')

@section('titulo','index')

@section('contenido')

    <div class="container mt-5">
        <h2 class="mb-4">Resumen Importe</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    
                    <th>Mes</th>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Asignado</th>
                    <th>N de factura</th>
                    <th>Consumo</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Empresa</th>
                    <th>Costo</th>
                    <th>Gasto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumenimportes as $registroimporte)
                <tr>
                <td>{{$registroimporte->mes}}</td>
                <td>{{$registroimporte->fecha}}</td>
                <td>{{$registroimporte->equipo}}</td>
                <td>{{$registroimporte->marca}}</td>
                <td>{{$registroimporte->placa}}</td>
                <td>{{$registroimporte->asignado}}</td>
                <td>{{$registroimporte->numfac}}</td>
                <td>{{$registroimporte->consumo}}</td>
                <td>{{$registroimporte->precio}}</td>
                <td>{{$registroimporte->total}}</td>
                <td>{{$registroimporte->empresa}}</td>
                <td>{{$registroimporte->costo}}</td>
                <td>{{$registroimporte->gasto}}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </td>
                </tr>

                @empty
                
                @endforelse

            </tbody>
        </table>
        <a href="{{route('registroimporte.create')}}" class="btn btn-success">Agregar Nuevo</a>
    </div>


{{ $resumenimportes->render('pagination::bootstrap-4') }}

@endsection()