@extends("layouts.app")

@section("title", "Create Admin User")

@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-user tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Create Admin User</h5>
        </div>
        <div></div>
    </div>
@endsection

@section("content")
    <x-card class="pb-5">
    </x-card>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endpush
