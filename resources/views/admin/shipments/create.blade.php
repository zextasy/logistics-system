<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Create Shipment</h2>
        </div>
    </x-slot>
    <div class="py-12 px-14">
        <livewire:forms.create-shipment></livewire:forms.create-shipment>
    </div>
</x-app-layout>
