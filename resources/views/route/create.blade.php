@extends("layouts.app")

@section("title", "Create Route")
@section("route-page-active", "active")

@section("style")
    <style>
        .calendar-table {
            display: none;
        }
        .daterangepicker .drp-calendar.left {
            padding: 8px !important;
        }
        .select2-selection {
            height: 42px !important;
        }
    </style>
@endsection

@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-route tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Create Route</h5>
        </div>
        <div></div>
    </div>
@endsection


@section("content")
    <x-card>
        <form method="post" action="{{ route("route.store") }}" class="repeater" id="submit-form">
            @csrf
            @method("post")

            <div class="form-group">
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('title')" />
            </div>

            <div class="form-group">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <x-input-label for="direction" value="Direction" />
                <select name="direction" class="custom-select">
                    <option value="clockwise" @if(old('direction') == 'clockwise') selected @endif>Clockwise</option>
                    <option value="anticlockwise" @if(old('direction') == 'anticlockwise') selected @endif>Anticlockwise</option>
                </select>
            </div>

            <div class="tw-mb-3">
                <x-input-label for="schedule" value="Schedule" />
                <div data-repeater-list="schedule">
                    @forelse ($schedule as $item )
                        <div data-repeater-item class="tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg tw-relative">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="station" value="Station" />
                                        <select name="station_id" class="custom-select station-id" id="">
                                            <option value="{{ $item['station_id'] }}" selected>
                                                {{ $item['station_title'] }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="time" value="Time" />
                                        <x-text-input id="time" name="time" type="text" class="tw-mt-1 tw-block tw-w-full timepicker" value="{{ $item['time'] }}"/>
                                    </div>
                                </div>
                            </div>
                            <button data-repeater-delete type="button" class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest tw-hover:bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-absolute tw-top-0 tw-right-0">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    @empty
                        <div data-repeater-item class="tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg tw-relative">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="station" value="Station" />
                                        <select name="station_id" class="custom-select station-id" id="">
                                            <option value="" selected>-- Please Choose --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="time" value="Time" />
                                        <x-text-input id="time" name="time" type="text" class="tw-mt-1 tw-block tw-w-full timepicker"/>
                                    </div>
                                </div>
                            </div>
                            <button data-repeater-delete type="button" class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest tw-hover:bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-absolute tw-top-0 tw-right-0">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    @endforelse
                    </div>
                    <div class="tw-flex">
                        <button data-repeater-create type="button" class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-gray-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest tw-hover:bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150">
                            <i class="fas fa-plus-circle"></i> Add Schedule
                        </button>
                    </div>
            </div>

            <div class="tw-flex tw-justify-center tw-items-center tw-mt-5 tw-gap-4">
                <x-confirm-button>Confirm</x-confirm-button>
                <x-cancel-button href="{{ route('route.index') }}">Cancel</x-cancel-button>
            </div>
        </form>
    </x-card>
@endsection


@push("scripts")
    <script>
        $(document).ready(function() {
            $('.repeater').repeater({
                
                show: function () {
                    $(this).slideDown();
                    initStationSelect2();
                    initTimePicker();
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function() {
                    initStationSelect2();
                    initTimePicker();
                },
                isFirstItemUndeletable: false
            });

            function initStationSelect2() {
                $('.station-id').select2({
                    placeholder: '-- Please Choose --',
                    ajax: {
                        url: '{{ route('select2-ajax.station') }}',
                        data: function (params) {
                            return {
                                search: params.term,
                                page: params.page || 1
                            }
                        },
                        processResults: function(response) {
                            console.log(response);
                            return {
                                results: $.map(response.data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.title
                                    };
                                }),
                                pagination: {
                                    more: response.next_page_url != null ? true : false
                                }
                            };
                        },
                        cache: true
                    }
                });
            }

            function initTimePicker() {
                $('.timepicker').daterangepicker({
                    "singleDatePicker": true,
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "autoApply": true,
                    "locale": {
                        format: 'HH:mm:ss'
                    },
                });
            }

        });
    </script>
@endpush

@push("scripts")
    {!! JsValidator::formRequest("App\Http\Requests\RouteStoreRequest", "#submit-form") !!}
@endpush
