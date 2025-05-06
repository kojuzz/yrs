@extends("layouts.app")

@section("title", "Edit Route")
@section("route-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-subway tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Route</h5>
        </div>
        <div></div>
    </div>
@endsection


@section('content')
    <x-card>
        <form method="post" action="{{ route('route.update', $route->id) }}" class="" id="submit-form">
            @csrf
            @method('put')
        
            <div class="form-group">
                <x-input-label for="title" value="Title" />
                <x-text-input id="title" name="title" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('title', $route->title)" />
            </div>
            
            <div class="form-group">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" class="form-control">{{ old('description', $route->description) }}</textarea>
            </div>

            <div class="form-group">
                <x-input-label for="location" value="Location" />
                <x-text-input id="location" name="location" type="text" class="tw-mt-1 tw-block tw-w-full location" :value="old('location', $route->latitude.', '.$route->longitude)" />
                <div class="map-container tw-my-3 border"></div>
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
            $('.location').leafletLocationPicker({
                mapContainer: '.map-container',
                height: '400px',
                alwaysOpen: true,
                // layer: 'mapTiler',
                map: {
                    center: [16.781040, 96.161935],
                    zoom: 15
                },
                
            });
        });
    </script>
@endpush

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\RouteUpdateRequest', '#submit-form') !!}
@endpush