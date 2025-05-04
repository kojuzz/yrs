@extends("layouts.app")

@section("title", "Top Up History Detail")
@section("top-up-history-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-image tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Top Up History Detail</h5>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="pb-5">
        <table class="tw-w-full">
            <tbody>
                <tr>
                    <td class="text-left" style="width: 45%">Trx Id</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->trx_id }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">User</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->user->name }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Amount</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ number_format($top_up_history->amount) }} MMK</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Description</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->description ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Status</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $top_up_history->acsrStatus['color'] }}">
                            {{ $top_up_history->acsrStatus['text'] }} 
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Approved at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->approved_at ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Rejected at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->rejected_at ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Created at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->created_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Updated at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $top_up_history->updated_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Image</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <div class="tw-flex tw-justify-end">
                            <img src="{{ $top_up_history->acsrImagePath }}" alt="Image" class="tw-w-20 tw-h-20 tw-rounded-lg tw-shadow tw-object-cover" id="image">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </x-card>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            new Viewer(document.getElementById('image'));
        });
    </script>
@endpush
