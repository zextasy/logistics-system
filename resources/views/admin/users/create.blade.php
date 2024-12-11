<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Create User</h2>
        </div>
    </x-slot>
    <div class="py-12 px-14">
        <livewire:forms.create-user></livewire:forms.create-user>
    </div>
</x-app-layout>