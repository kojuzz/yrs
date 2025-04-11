@props(['value'])

<label {{ $attributes->merge(['class' => 'tw-block tw-font-medium tw-text-sm tw-text-gray-700 tw-mb-1']) }}>
    {{ $value ?? $slot }}
</label>
