{{-- resources/views/admin/quotes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">Quote Requests</h2>
                <div class="flex space-x-3">
                </div>
            </div>
        </div>
    </x-slot>
    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        @foreach([
            ['Pending', $stats['pending'], 'clock', 'bg-yellow-600'],
            ['Processing', $stats['processing'], 'refresh', 'bg-blue-600'],
            ['Quoted', $stats['quoted'], 'check', 'bg-green-600'],
            ['Rejected', $stats['rejected'], 'x', 'bg-red-600']
        ] as [$label, $count, $icon, $color])
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="{{ $color }} rounded-full p-3">
                        {{--                                <x-icon :name="$icon" class="w-6 h-6 text-white" />--}}
                    </div>
                    <div class="ml-5">
                        <p class="text-gray-500">{{ $label }}</p>
                        <p class="text-2xl font-bold">{{ number_format($count) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quotes Table -->
    <livewire:tables.quote-index></livewire:tables.quote-index>
</x-app-layout>
