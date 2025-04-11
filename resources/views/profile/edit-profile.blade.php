@extends('layouts.app')

@section('title', 'Edit Profile')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-th tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Profile</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    
        <form method="post" action="{{ route('profile.update') }}" class="">
            @csrf
            @method('patch')
    
            <div class="form-group">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="tw-mt-2" :messages="$errors->get('name')" />
            </div>
    
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="tw-mt-1 tw-block tw-w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="tw-mt-2" :messages="$errors->get('email')" />
    
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="tw-text-sm tw-mt-2 tw-text-gray-800">
                            {{ __('Your email address is unverified.') }}
    
                            <button form="send-verification" class="tw-underline tw-text-sm tw-text-gray-600 hover:tw-text-gray-900 tw-rounded-md tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-offset-2 tw-focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
    
                        @if (session('status') === 'verification-link-sent')
                            <p class="tw-mt-2 tw-font-medium tw-text-sm tw-text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
    
            <div class="tw-flex tw-justify-center tw-items-center tw-mt-5 tw-gap-4">
                <x-confirm-button>Confirm</x-confirm-button>
                <x-cancel-button href="{{ route('dashboard') }}">Cancel</x-cancel-button>
            </div>
        </form>
    </x-card>
@endsection