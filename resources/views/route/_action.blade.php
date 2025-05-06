<x-detail-button href="{{ route('route.show', $route->id) }}">
    <i class="fas fa-info-circle"></i>
</x-detail-button>
<x-edit-button href="{{ route('route.edit', $route->id) }}">
    <i class="fas fa-edit"></i>
</x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{ route('route.destroy', $route->id) }}">
    <i class="fas fa-trash"></i>
</x-delete-button>
