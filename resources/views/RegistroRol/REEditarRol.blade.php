@extends('Layouts.app')

@section('titulo', 'Editar Rol')

@section('contenido')

<div class="container mt-5"> <!--Contenedor con margen superior para espaciar del borde superior. -->
    <div class="card">  <!--Tarjeta estilo Bootstrap para encapsular contenido con sombra y borde. -->
        <div class="card-header">  <!-- Encabezado.-->
            <h3>Editar Estado de Rol</h3>  <!-- Título principal del formulario. -->
        </div>
        <div class="card-body text-center">  <!-- Cuerpo de la tarjeta, centrado horizontalmente.-->
            <h4>{{ $role->rol }}</h4>  <!-- Muestra el nombre del rol que se está editando. -->
             <!--Botón dinámico para el estado del usuario. -->
            <button id="toggleEstado"   
                class="btn {{ $role->estado ? 'btn-success' : 'btn-danger' }} toggleEstado"  
                data-id="{{ $role->id }}" data-estado="{{ $role->estado }}">
                {{ $role->estado ? 'Activo' : 'Inactivo' }}
            </button>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {  // Espera a que el documento esté completamente cargado.
        $('#toggleEstado').click(function() { // Evento click sobre el botón con ID 'toggleEstado'.
            let button = $(this);
            let roleId = button.data('id'); // Obtiene el ID del rol desde el atributo data-id.
            let newEstado = button.data('estado') == 1 ? 0 : 1; // Calcula el nuevo estado (si es 1 pasa a 0, y viceversa).

            $.ajax({
                url: "{{ route('roles.toggleEstado') }}", // Ruta que manejará el cambio de estado (definida en rutas Laravel).
                method: "POST",  // Método HTTP para enviar la petición.
                data: {
                    _token: "{{ csrf_token() }}", // Token CSRF para proteger la petición.
                    id: roleId, // ID del rol a cambiar.
                    estado: newEstado // Nuevo estado a aplicar.
                },
                success: function(response) { // Función que se ejecuta si la petición es exitosa.
                    if (response.success) { // Si el servidor responde con éxito.
                        button.data('estado', newEstado); // Actualiza el atributo data-estado del botón.
                        button.text(newEstado ? 'Activo' : 'Inactivo'); // Cambia el texto del botón.
                        button.toggleClass('btn-success btn-danger'); // Cambia las clases CSS para reflejar el nuevo estado.
                    }
                }
            });
        });
    });
</script>
@endsection
