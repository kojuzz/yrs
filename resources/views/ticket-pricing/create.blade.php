@extends("layouts.app")

@section("title", "Create Ticket Pricing")
@section("ticket-pricing-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-tag tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Create Ticket Pricing</h5>
        </div>
        <div></div>
    </div>
@endsection


@section('content')
    <x-card>
        <form method="post" action="{{ route('ticket-pricing.store') }}" class="" id="submit-form">
            @csrf
            @method('post')
    
            <div class="form-group">
                <x-input-label for="type" value="Type" />
                <select name="type" id="" class="custom-select">
                    <option value="one_time_ticket" @if(old('type') == 'one_time_ticket') selected @endif>One Time Ticket</option>
                    <option value="one_month_ticket" @if(old('type') == 'one_month_ticket') selected @endif>One Month Ticket</option>
                </select>
            </div>
            
            <div class="form-group">
                <x-input-label for="price" value="Price" />
                <x-text-input id="price" name="price" type="number" class="tw-mt-1 tw-block tw-w-full" :value="old('price')" />
            </div>

            <div class="form-group">
                <x-input-label for="offer_quantity" value="Offer Quantity" />
                <x-text-input id="offer_quantity" name="offer_quantity" type="number" class="tw-mt-1 tw-block tw-w-full" :value="old('offer_quantity')" />
            </div>

            <div class="form-group">
                <x-input-label for="period" value="Period" />
                <x-text-input id="period" name="period" type="text" class="tw-mt-1 tw-block tw-w-full datetimepicker" :value="old('period')" />
            </div>
    
            <div class="tw-flex tw-justify-center tw-items-center tw-mt-5 tw-gap-4">
                <x-confirm-button>Confirm</x-confirm-button>
                <x-cancel-button href="{{ route('ticket-pricing.index') }}">Cancel</x-cancel-button>
            </div>
        </form>
    </x-card>
@endsection


@push("scripts")
    <script>
        $(document).ready(function() {
            
                $('.datetimepicker').daterangepicker({
                    "drops": "up",
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "autoApply": true,
                    "locale": {
                        format: 'YYYY-MM-DD HH:mm:ss'
                    },
                });
                
        });
    </script>
@endpush

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\TicketPricingStoreRequest', '#submit-form') !!}
@endpush