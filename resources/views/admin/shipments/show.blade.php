<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Shipment Details</h2>
            <div class="flex space-x-3">
                @if($shipment->initialDocument()->doesntExist())
                    <livewire:actions.shipment-document-generator :shipment="$shipment" />
                @endif
                    <livewire:actions.shipment-management-actions :shipment="$shipment" />
            </div>
            <span class="px-4 py-2 mx-3 rounded-full text-sm
                            @if($shipment->status->value === 'delivered')
                                bg-green-100 text-green-800
                            @elseif($shipment->status->value === 'in_transit')
                                bg-blue-100 text-blue-800
                            @elseif($shipment->status->value === 'pending')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst($shipment->status->value) }}
                        </span>
        </div>
    </x-slot>
    <div class="py-12 px-14">
        <x-shipment-details-card :shipment="$shipment"></x-shipment-details-card>
        {{-- Shipment Route Table --}}
        <livewire:tables.shipment-route-index :shipment="$shipment"/>
    </div>
</x-app-layout>
