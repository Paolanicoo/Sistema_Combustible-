@extends('Layouts.app')

@section('titulo','index')

@section('contenido')

<!DOCTYPE html>
<html>
    <head>
        <title>Gestión de Roles - Datatables</title>
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
    <div class="container mt-5">
    <div class="card p-3"> <!-- Agregamos un padding al card -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><b>Gestión de Roles</b></h3>
            <button class="btn btn-info btn-sm">
                <i class="fas fa-plus"></i> Nuevo Registro
            </button>
        </div>
        <div class="table-responsive mt-3"> <!-- Agregar margen arriba -->
            <table class="table table-bordered table-striped w-100" id="roles-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Rol</th>  
                    <th>Acciones</th>             
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('registrorol.table') }}',
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'tipo_rol', name: 'tipo_rol'},   
                        {data: 'acciones', name: 'acciones', orderable: false, searchable: false} // Nueva columna
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

            // Función para editar el rol
            function editarRol(id) {
                // Mostrar el modal de edición
                $('#editarModal').modal('show');
                
                // Hacer una solicitud para obtener los detalles del rol
                $.ajax({
                    url: '/roles/editar/' + id,
                    method: 'GET',
                    success: function(data) {
                        // Pre-poblar el modal con los datos del rol
                        $('#editar-id').val(data.id);
                        $('#editar-tipo_rol').val(data.tipo_rol);
                    }
                });
            }

            function desactivarRol(id) {
                if (!id) {
                    alert("ID no válido");
                    return;
                }

                // Confirmación con modal (si tienes uno) o alert
                if (!confirm("¿Estás seguro de que deseas desactivar este rol?")) {
                    return;
                }

                $.ajax({
                    url: '/roles/desactivar/' + id,  // Verifica que esta ruta es la correcta
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Rol desactivado exitosamente');
                        $('#roles-table').DataTable().ajax.reload(); // Recargar la tabla
                    },
                    error: function(xhr) {
                        alert('Error al desactivar el rol: ' + xhr.responseText);
                    }
                });
            }


        </script>
        <!-- Modal Editar -->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Rol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editarRolForm">
                            <div class="form-group">
                                <label for="editar-id">ID</label>
                                <input type="text" id="editar-id" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="editar-tipo_rol">Tipo de Rol</label>
                                <input type="text" id="editar-tipo_rol" class="form-control">
                            </div>
                            <!-- Agrega más campos si es necesario -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmación Desactivación -->
        <div class="modal fade" id="confirmarDesactivacionModal" tabindex="-1" role="dialog" aria-labelledby="confirmarDesactivacionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarDesactivacionModalLabel">Confirmar Desactivación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas desactivar este rol?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarDesactivar">Desactivar</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

    