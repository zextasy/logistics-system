{{-- resources/views/components/status-badge.blade.php --}}
@props(['status'])

@php
    $classes = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-800',
        'in_transit' => 'bg-blue-100 text-blue-800',
        'delivered' => 'bg-green-100 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800'
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
