@extends('Layouts.app')

@section('titulo', 'Editar Rol')

@section('contenido')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Editar Rol</h3>
        </div>
        <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
         @csrf
         @method('PUT')
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" id="rol" class="form-control" required>
    <option value="Administrador" {{ $role->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
    <option value="Usuario" {{ $role->rol == 'Usuario' ? 'selected' : '' }}>Usuario</option>
    <option value="Visualizador" {{ $role->rol == 'Visualizador' ? 'selected' : '' }}>Visualizador</option>
</select>

<select name="estado" id="estado" class="form-control" required>
    <option value="1" {{ $role->estado ? 'selected' : '' }}>Activo</option>
    <option value="0" {{ !$role->estado ? 'selected' : '' }}>Inactivo</option>
</select>

                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('registrorol.table') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
