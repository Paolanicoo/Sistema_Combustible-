@extends('Layouts.app')

@section('titulo', 'Gestión de Roles')

@section('contenido')

<style>
    /* Ajustar el ancho de la columna "Acciones" */
    .acciones-columna {
        width: 120px;
        text-align: center;
    }

    /* Centrar los botones en la columna de acciones */
    .acciones-columna div {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    

</style>

<!-- Ajustamos el margen superior para que suba un poco -->
<div class="container mt-5">
    <div class="card p-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><b>Registro de roles</b></h3>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped w-100" id="roles-table">
                <thead>
                    <tr>
                        <th class="rol-columna text-center">Rol</th>  
                        <th class="estado-columna text-center">Estado</th>
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
        searching: false, // Desactiva la barra de búsqueda
        paging: false, // Desactiva la paginación
        language: {
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
            
        },
        lengthChange: false // Oculta la opción de cambiar el número de registros mostrados
    });

   // Evento para cambiar el estado con AJAX
    $('#roles-table').on('click', '.toggleEstado', function() {
        let button = $(this);
        let roleId = button.data('id');
        let newEstado = button.data('estado') == 1 ? 0 : 1;
        let accion = newEstado == 1 ? 'activar' : 'desactivar';
        let mensaje = newEstado == 1 ? 'activado' : 'desactivado';
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas ${accion} este rol?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
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
                            Swal.fire(
                                '¡Listo!',
                                `El rol ha sido ${mensaje} correctamente.`,
                                'success'
                            );
                            table.ajax.reload(); // Recarga la tabla automáticamente
                        } else {
                            Swal.fire(
                                'Error',
                                response.message || 'Ha ocurrido un error.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'Ha ocurrido un error en la operación.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

@endsection
