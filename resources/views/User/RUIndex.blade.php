@extends('Layouts.app')

@section('titulo', 'User')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')
@include('User.RUCreate')


<meta name="csrf-token" content="{{ csrf_token() }}"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Para el paquete de SweetAlert configurado -->
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Reducir ancho de la columna "Acciones" */
    .acciones-columna {
        width: 40px; /* Aumenté el tamaño para permitir más espacio para los botones */
        text-align: center;
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
</style>

<div class="container mt-5">
    <div class="card p-4"> <!-- Aumenté el padding aquí para la separación -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><b>Registro de usuarios</b></h3>
            @if(Auth::user()->role !== 'Visualizador')
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                <i class="fas fa-plus"></i> Nuevo registro
            </button>

                </a>
            @endif
        </div>
        <div class="table-responsive mt-3">
    <table class="table table-bordered table-striped w-100" id="users-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th class="acciones-columna text-center">Acciones</th> <!-- Centrado y ancho ajustado -->
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('user.table') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'role', name: 'role'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'acciones-columna'}
            ],
            language: {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>




@endsection