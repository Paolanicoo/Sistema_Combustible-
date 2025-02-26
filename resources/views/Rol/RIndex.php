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
            <h2 class="mb-4">Gestión de Roles</h2>
            <table class="table table-bordered table-striped" id="roles-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Rol</th>               
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
        $(document).ready(function () {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('registrorol.table') }}',

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'nombre', name: 'rol'},       
                ],
                language: {
                    "processing":     "Procesando...",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "zeroRecords":    "No se encontraron resultados",
                    "emptyTable":     "No hay datos disponibles en esta tabla",
                    "info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "search":         "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "loadingRecords": "Cargando...",
                    "aria": {
                        "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
        </script>
    </body>
</html>