<x-detail-button href="{{ route('top-up-history.show', $top_up_history->id) }}">
    <i class="fas fa-info-circle"></i>
</x-detail-button>
@if ($top_up_history->status == 'pending')
    <x-approve-button href="#" class="approve-button" data-url="{{ route('top-up-history-approve', $top_up_history->id) }}">
        <i class="fas fa-check-circle"></i>
    </x-approve-button>
    <x-reject-button href="#" class="reject-button" data-url="{{ route('top-up-history-reject', $top_up_history->id) }}">
        <i class="fas fa-times-circle"></i>
    </x-reject-button>
@endif