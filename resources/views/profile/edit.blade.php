@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="py-12">
        <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8 tw-space-y-6">
            <div class="p-4 sm:p-8 tw-bg-white tw-shadow sm:tw-rounded-lg">
                <div class="tw-max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="tw-p-4 sm:tw-p-8 tw-bg-white tw-shadow sm:tw-rounded-lg">
                <div class="tw-max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="tw-p-4 sm:tw-p-8 tw-bg-white tw-shadow sm:tw-rounded-lg">
                <div class="tw-max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
