{{-- resources/views/components/description-title.blade.php --}}
@props(['value'])

<dt {{ $attributes->merge(['class' => 'text-sm font-medium text-gray-500']) }}>
    {{ $value ?? $slot }}
</dt>
