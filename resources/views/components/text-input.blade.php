@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'tw-border-gray-300 tw-focus:tw-border-indigo-500 tw-focus:tw-ring-indigo-500 tw-rounded-md tw-shadow-sm']) !!}>
