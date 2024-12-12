<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Shipment Details</h2>
                        <span class="px-4 py-2 rounded-full text-sm
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
                            {{ strtoupper($shipment->status->getLabel()) }}
                        </span>
                    </div>

                    {{-- Shipment Overview --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium mb-4">Shipment Information</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tracking Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $shipment->tracking_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ strtoupper($shipment->service_type->getLabel()) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Current Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ strtoupper($shipment->current_location) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-4">Delivery</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expected Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $shipment->estimated_delivery->toFormattedDateString() }}
                                    </dd>
                                </div>
                                @if($shipment->actual_delivery)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Actual Delivery</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $shipment->actual_delivery->toFormattedDateString()}}
                                        </dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description of Goods</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ strtoupper($shipment->description) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    {{-- Shipment Route Timeline --}}
                    <x-shipment-route-timeline-card :shipment="$shipment"/>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
