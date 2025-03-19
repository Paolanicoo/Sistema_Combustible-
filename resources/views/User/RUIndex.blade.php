@extends('Layouts.app')

@section('titulo', 'User')

@section('contenido')

<!--asegura que los mensajes de SweetAlert se muestren -->
@include('sweetalert::alert')

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
            <a href="{{ route('user.create') }}" class="btn btn-info btn-sm">
    <i class="fas fa-plus"></i> Nuevo Registro
</a>
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


<!-- Modal para editar usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editUsuarioId" name="id">
                    <div class="mb-3">
                        <label for="editNombreUsuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombreUsuario" name="nombre" required>
                        <div id="editNombreFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editRolUsuario" class="form-label">Rol</label>
                        <select class="form-control" id="editRolUsuario" name="rol" required>
                            <option value="">Seleccione un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Editor">Editor</option>
                            <option value="Visualizador">Visualizador</option>
                        </select>
                        <div id="editRolFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPasswordUsuario" class="form-label">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                        <input type="password" class="form-control" id="editPasswordUsuario" name="password">
                        <div id="editPasswordFeedback" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPasswordConfirmUsuario" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="editPasswordConfirmUsuario" name="password_confirmation">
                        <div id="editPasswordConfirmFeedback" class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnActualizarUsuario" class="btn btn-success">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el modal correctamente
    const modalEditarUsuario = document.getElementById('modalEditarUsuario');
    const modalEdit = bootstrap.Modal.getInstance(modalEditarUsuario) || new bootstrap.Modal(modalEditarUsuario);

    // Manejo del evento para abrir el modal y cargar datos del usuario
    document.addEventListener('click', function(e) {
        const editButton = e.target.closest('.edit-btn');
        if (editButton) {
            e.preventDefault();
            const userId = editButton.getAttribute('data-id');

            console.log("Editando usuario con ID:", userId); // Para depuración

            // Limpiar los mensajes de error previos
            document.querySelectorAll('#formEditarUsuario .is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });

            // Cargar los datos del usuario
            fetch(`/user/getUser/${userId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                // Verificar si la respuesta es correcta antes de intentar parsearlo como JSON
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Llenar el formulario con los datos del usuario
                    document.getElementById('editUsuarioId').value = data.usuario.id;
                    document.getElementById('editNombreUsuario').value = data.usuario.nombre;
                    document.getElementById('editRolUsuario').value = data.usuario.rol;

                    // Limpiar los campos de contraseña
                    document.getElementById('editPasswordUsuario').value = '';
                    document.getElementById('editPasswordConfirmUsuario').value = '';

                    // Mostrar el modal
                    modalEdit.show();
                } else {
                    Swal.fire("Error", "No se pudo cargar la información del usuario", "error");
                }
            })
            .catch(error => {
                console.error("Error al obtener usuario:", error);
                Swal.fire("Error", "Ocurrió un error al cargar la información del usuario", "error");
            });
        }
    });

    // Manejar el envío del formulario de edición
    document.getElementById("btnActualizarUsuario").addEventListener("click", function() {
        // Limpiar feedbacks de error previos
        document.querySelectorAll('#formEditarUsuario .is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });

        let usuarioId = document.getElementById("editUsuarioId").value;
        let nombre = document.getElementById("editNombreUsuario").value;
        let rol = document.getElementById("editRolUsuario").value;
        let password = document.getElementById("editPasswordUsuario").value;
        let passwordConfirm = document.getElementById("editPasswordConfirmUsuario").value;

        // Validar que las contraseñas coincidan si se está cambiando
        if (password !== '' && password !== passwordConfirm) {
            document.getElementById("editPasswordConfirmUsuario").classList.add('is-invalid');
            document.getElementById("editPasswordConfirmFeedback").textContent = "Las contraseñas no coinciden";
            return;
        }

        // Obtener el token CSRF
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        // Crear FormData para enviar los datos
        let formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('rol', rol);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        // Agregar contraseña solo si se ha proporcionado una nueva
        if (password !== '') {
            formData.append('password', password);
            formData.append('password_confirmation', passwordConfirm);
        }

        // Corregir la URL y usar usuarioId en lugar de userId
        // Construir la URL manualmente si no funciona la plantilla de ruta
        fetch(`/user/update/${usuarioId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token
            },
            body: formData
        })
        .then(response => {
            // Verificar si la respuesta es correcta antes de intentar parsearlo como JSON
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Éxito",
                    text: data.message || "Usuario actualizado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    // Cerrar el modal
                    modalEdit.hide();

                    // Recargar la tabla de DataTables
                    if ($.fn.DataTable.isDataTable('#users-table')) {
                        $('#users-table').DataTable().ajax.reload();
                    } else {
                        location.reload();
                    }
                });
            } else {
                // Manejar errores de validación
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        let field = key === 'nombre' ? 'editNombreUsuario' :
                                    key === 'rol' ? 'editRolUsuario' : 
                                    key === 'password' ? 'editPasswordUsuario' :
                                    key === 'password_confirmation' ? 'editPasswordConfirmUsuario' : '';

                        if (field) {
                            document.getElementById(field).classList.add('is-invalid');
                            let feedback = document.getElementById(field + 'Feedback');
                            if (feedback) {
                                feedback.textContent = data.errors[key][0];
                            }
                        }
                    });
                } else {
                    Swal.fire("Error", data.message || "No se pudo actualizar el usuario", "error");
                }
            }
        })
        .catch(error => {
            console.error("Error al actualizar usuario:", error);
            Swal.fire("Error", "Ocurrió un error al procesar la solicitud", "error");
        });
    });
});
</script>
@endsection