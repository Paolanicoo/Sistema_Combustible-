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
        <div class="container mt-5 pt-3"> <!-- Margen superior más grande -->
            <div class="card p-3 mt-3"> <!-- Añadido margen superior al card -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><b>Registro de roles</b></h3>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped w-100" id="roles-table">
                        <thead>
                            <tr>
                                <th>Rol</th>  
                                <th>Estado</th>
                                <th class="acciones-columna text-center">Acciones</th> <!-- Centrado y ancho ajustado -->           
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                        {data: 'rol', name: 'rol'},
                        { data: 'estado_texto', name: 'estado_texto' },   
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
            });
        </script>
    </body>
</html>


    