@extends('Layouts.app')

@section('titulo', 'Editar Rol')

@section('contenido')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Editar Estado de Rol</h3>
        </div>
        <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
         @csrf
         @method('PUT')
                <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
    <input type="text" class="form-control" id="rol" name="rol" value="{{ $role->rol }}" readonly>

    <label for="estado" class="form-label">Estado</label>
    <select name="estado" id="estado" class="form-control" required>
        <option value="1" {{ $role->estado == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ $role->estado == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>

                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('registrorol.table') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
