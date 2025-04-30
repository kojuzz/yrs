@extends("layouts.app")

@section("title", "Wallet Transaction Detail")
@section("wallet-transaction-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Wallet Transaction Detail</h5>
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
                    <td class="text-right" style="width: 45%">{{ $wallet_transaction->trx_id }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">From</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $wallet_transaction->acsrFrom }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">To</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $wallet_transaction->acsrTo }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Type</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $wallet_transaction->acsrType['color'] }}">
                            {{ $wallet_transaction->acsrType['text'] }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Amount</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $wallet_transaction->acsrMethod['color'] }}">
                            {{ number_format($wallet_transaction->amount) }} MMK
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Created at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $wallet_transaction->created_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Description</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $wallet_transaction->description }}</td>
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
