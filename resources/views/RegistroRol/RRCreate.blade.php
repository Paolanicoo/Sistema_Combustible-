@extends('Layouts.app')

@section('titulo', 'Gestión de Roles')

@section('contenido')

<div class="container mt-5 pt-3">
    <div class="card p-3 mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><b>Registro de Roles</b></h3>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped w-100" id="roles-table">
                <thead>
                    <tr>
                        <th>Rol</th>  
                        <th>Estado</th>
                        <th class="acciones-columna text-center">Acciones</th>        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('registrorol.table') }}',
        columns: [
            {data: 'rol', name: 'rol'},
            {data: 'estado_texto', name: 'estado_texto', orderable: false, searchable: false},
            {data: 'acciones', name: 'acciones', orderable: false, searchable: false}
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

    // Evento para cambiar el estado con AJAX
    $('#roles-table').on('click', '.toggleEstado', function() {
        let button = $(this);
        let roleId = button.data('id');
        let newEstado = button.data('estado') == 1 ? 0 : 1;

        $.ajax({
            url: "{{ route('roles.toggleEstado') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: roleId,
                estado: newEstado
            },
            success: function(response) {
                if (response.success) {
                    table.ajax.reload(); // Recarga la tabla automáticamente
                } else {
                    alert(response.message); // Muestra alerta si no puede desactivar
                }
            }
        });
    });
});
</script>


@endsection
