@extends("layouts.app")

@section("title", "Ticket Detail")
@section("ticket-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-ticket-alt tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Ticket Detail</h5>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="pb-5">
        <table class="tw-w-full">
            <tbody>
                <tr>
                    <td class="text-left" style="width: 45%">Ticket Number</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $ticket->ticket_number }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">User</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        {{ $ticket->user ? ($ticket->user->name. ' ('.$ticket->user->email.')') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Type</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $ticket->acsrType['color'] }}">
                            {{ $ticket->acsrType['text'] }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Direction</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $ticket->acsrDirection['color'] }}">
                            {{ $ticket->acsrDirection['text'] }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Price</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ number_format($ticket->price) }} MMK</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Valid at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $ticket->valid_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Expired at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $ticket->expire_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Created at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $ticket->created_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Updated at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $ticket->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </x-card>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endpush
