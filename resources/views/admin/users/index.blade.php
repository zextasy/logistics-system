<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Users</h2>
        </div>
    </x-slot>
    <livewire:tables.user-index></livewire:tables.user-index>
</x-app-layout>
