<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Quote Request Details</h2>
            <span class="px-4 py-2 rounded-full text-sm
                            @if($quote->status === 'delivered')
                                bg-green-100 text-green-800
                            @elseif($quote->status === 'in_transit')
                                bg-blue-100 text-blue-800
                            @elseif($quote->status === 'pending')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst($quote->status) }}
                        </span>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    {{-- Contact Information --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium mb-4">Contact Information</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <x-description-list-title>Reference Number</x-description-list-title>
                                <x-description-list-text>{{ $quote->reference_number }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Company Name</x-description-list-title>
                                <x-description-list-text>{{ $quote->company }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Full Name</x-description-list-title>
                                <x-description-list-text>{{ $quote->name }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Email</x-description-list-title>
                                <x-description-list-text>{{ $quote->email }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Phone</x-description-list-title>
                                <x-description-list-text>{{ $quote->phone }}</x-description-list-text>
                            </div>
                        </dl>
                    </div>
                    {{-- Shipment Details --}}
                    <div>
                        <h3 class="text-lg font-medium mb-4">Shipment Details</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <x-description-list-title>Origin</x-description-list-title>
                                <x-description-list-text>{{ $quote->origin_country_name }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Destination</x-description-list-title>
                                <x-description-list-text>{{ $quote->destination_country_name }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Service Type</x-description-list-title>
                                <x-description-list-text>{{ $quote->service_type }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Cargo Type</x-description-list-title>
                                <x-description-list-text>{{ $quote->cargo_type }}</x-description-list-text>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- Cargo Details --}}
                    <div >
                        <h3 class="text-lg font-medium mb-4">Cargo Details</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div>
                                <x-description-list-title>Cargo Description</x-description-list-title>
                                <x-description-list-text>{{ $quote->cargo_description }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Weight</x-description-list-title>
                                <x-description-list-text>{{ $quote->weight }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Number of Pieces</x-description-list-title>
                                <x-description-list-text>{{ $quote->number_of_pieces }}</x-description-list-text>
                            </div>
                            <div>
                                <x-description-list-title>Container Size</x-description-list-title>
                                <x-description-list-text>{{ $quote->container_size }}</x-description-list-text>
                            </div>
                        </dl>
                    </div>
                    {{-- Additional Services --}}
                    <div >
                    <h3 class="text-lg font-medium mb-4">Additional Services</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                        <div>
                            <x-description-list-title>Cargo Insurance Required</x-description-list-title>
                            <x-description-list-text>{{ $quote->cargo_description }}</x-description-list-text>
                        </div>
                        <div>
                            <x-description-list-title>Customs Clearance Required</x-description-list-title>
                            <x-description-list-text>{{ $quote->weight }}</x-description-list-text>
                        </div>
                        <div>
                            <x-description-list-title>Door Pickup Required</x-description-list-title>
                            <x-description-list-text>{{ $quote->number_of_pieces }}</x-description-list-text>
                        </div>
                        <div>
                            <x-description-list-title>Special Requirements</x-description-list-title>
                            <x-description-list-text>{{ $quote->container_size }}</x-description-list-text>
                        </div>
                    </dl>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
