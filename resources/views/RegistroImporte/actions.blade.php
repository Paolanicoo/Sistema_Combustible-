<div class="d-flex gap-2">
@if(Auth::user()->role !== 'Visualizador')
    <a href="{{ route('registroimporte.edit', $registro->id) }}" class="btn btn-warning btn-sm" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('registroimporte.destroy', $registro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
            <i class="fas fa-trash"></i>
        </button>
    </form>
@endif
</div>
