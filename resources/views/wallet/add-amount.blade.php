@extends("layouts.app")

@section("title", "Add Amount Wallet")
@section("wallet-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Add Amount to Wallet</h5>
        </div>
        <div></div>
    </div>
@endsection


@section('content')
    <x-card>
        <form method="post" action="{{ route('wallet-add-amount.store') }}" class="" id="submit-form">
            @csrf
            @method('post')
    
            <div class="form-group">
                <x-input-label for="wallet_id" value="Wallet" />
                <select name="wallet_id" id="wallet_id" class="custom-select">
                    
                </select>
            </div>
            
            <div class="form-group">
                <x-input-label for="amount" :value="__('Amount')" />
                <x-text-input id="amount" name="amount" type="number" class="tw-mt-1 tw-block tw-w-full" :value="old('amount')" />
            </div>
            
            <div class="form-group">
                <x-input-label for="description" :value="__('Description')" />
                <textarea name="description" id="description" class="form-control" :value="old('description')"></textarea>
            </div>
    
            <div class="tw-flex tw-justify-center tw-items-center tw-mt-5 tw-gap-4">
                <x-confirm-button>Confirm</x-confirm-button>
                <x-cancel-button href="{{ route('user.index') }}">Cancel</x-cancel-button>
            </div>
        </form>
    </x-card>
@endsection


@push("scripts")
    {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#submit-form') !!}
    
    <script>
        $(document).ready(function() {
            $('#wallet_id').select2({
                ajax: {
                    url: '{{ route('select2-ajax.wallet') }}',
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        }
                    },
                    processResults: function (response) {
                        console.log(response);
                        return {
                            results: $.map(response.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.user.name
                                };
                            }),
                            pagination: {
                                more: response.next_page_url != null ? true : false
                            }
                        };
                    }
                }
            });
        });
    </script>
@endpush
