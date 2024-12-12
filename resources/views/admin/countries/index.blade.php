<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Countries</h2>
        </div>
    </x-slot>
    <livewire:tables.country-index></livewire:tables.country-index>
</x-app-layout>
