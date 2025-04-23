@extends("layouts.app")

@section("title", "Edit User")
@section("user-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-user tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit User</h5>
        </div>
        <div></div>
    </div>
@endsection


@section('content')
    <x-card>
        <form method="post" action="{{ route('user.update', $user->id) }}" class="" id="submit-form">
            @csrf
            @method('put')
    
            <div class="form-group">
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('name', $user->name)" />
            </div>
            
            <div class="form-group">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="tw-mt-1 tw-block tw-w-full" :value="old('email', $user->email)" />
            </div>
            
            <div class="form-group">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="tw-mt-1 tw-block tw-w-full"/>
            </div>
    
            <div class="tw-flex tw-justify-center tw-items-center tw-mt-5 tw-gap-4">
                <x-confirm-button>Confirm</x-confirm-button>
                <x-cancel-button href="{{ route('user.index') }}">Cancel</x-cancel-button>
            </div>
        </form>
    </x-card>
@endsection


@push("scripts")
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endpush

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\UserUpdateRequest', '#submit-form') !!}
@endpush