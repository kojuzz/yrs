<x-edit-button href="{{ route('ticket-inspector.edit', $ticket_inspector->id) }}">
    <i class="fas fa-edit"></i>
</x-edit-button>
<x-delete-button href="#" class="delete-button" data-url="{{ route('ticket-inspector.destroy', $ticket_inspector->id) }}">
    <i class="fas fa-trash"></i>
</x-delete-button>
