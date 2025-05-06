@extends("layouts.app")

@section("title", "Route Detail")
@section("route-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-subway tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Route Detail</h5>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="pb-5">
        <table class="tw-w-full">
            <tbody>
                <tr>
                    <td class="text-left" style="width: 45%">Title</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->title }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Description</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->description }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Latitude</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->latitude }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Longitude</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->longitude }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Created at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $station->created_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Updated at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->updated_at }}</td>
                </tr>
            </tbody>
        </table>
        {{-- <div id="map" class="tw-h-96 tw-my-3"></div> --}}
    </x-card>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
        });
    </script>
@endpush
