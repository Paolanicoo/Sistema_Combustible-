@extends('Layouts.app')

@section('titulo', 'Gestión de Roles')

@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Gestión de Roles</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="roles-table">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Rol</th>               
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('registrorol.table') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'rol' }       
        ],
        language: {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "No hay datos disponibles en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "loadingRecords": "Cargando...",
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});
</script>
@endsection
