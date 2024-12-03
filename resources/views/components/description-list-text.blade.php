{{-- resources/views/components/description-text.blade.php --}}
@props(['value'])

<dt {{ $attributes->merge(['class' => 'mt-1 text-sm text-gray-900']) }}>
    {{ $value ?? $slot }}
</dt>
