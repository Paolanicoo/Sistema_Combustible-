<div class="d-flex gap-2">
    <a href="{{ route('registrovehicular.RVEdit', $registro->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> Editar
    </a>
    <form action="{{ route('registrovehicular.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> Eliminar
        </button>
    </form>
</div>
