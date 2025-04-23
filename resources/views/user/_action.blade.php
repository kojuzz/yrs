<x-edit-button href="{{ route('user.edit', $user->id) }}">
    <i class="fas fa-edit"></i>
</x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{ route('user.destroy', $user->id) }}">
    <i class="fas fa-trash"></i>
</x-delete-button>
