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
                    <td class="text-left" style="width: 45%">Direction</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">
                        <span style="color: #{{ $route->acsrDirection['color'] }}">
                            {{ $route->acsrDirection['text'] }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Created at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->created_at }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 45%">Updated at</td>
                    <td class="text-center" style="width: 10%">...</td>
                    <td class="text-right" style="width: 45%">{{ $route->updated_at }}</td>
                </tr>
            </tbody>
        </table>
        <div id="map" class="tw-h-96 tw-my-3"></div>
    </x-card>
@endsection

@push("scripts")
<script>
    $(document).ready(function() {
        var stations = @json($route->stations);
        console.log(stations);
        var map = L.map('map').setView([16.78106, 96.16194], 13); // မြေပုံ ပြတဲ့နေရာ, ပုံစံ

        // OpenStreetMap Layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Icon
        var myIcon = L.icon({
            iconUrl: "{{ asset('image/station.png') }}",
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        // Locations Markers
        stations.forEach(function(station) {
            L.marker([station['latitude'], station['longitude']], {
                icon: myIcon
            }).addTo(map)
                .bindPopup(`${station['title']} - ${station['pivot']['time']}`)
        });
    });
</script>
@endpush
