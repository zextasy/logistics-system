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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
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
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($shipment->service_type->value) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Current Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $shipment->current_location }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-4">Estimated Delivery</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expected Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $shipment->estimated_delivery }}{{-- ->format('M d, Y H:i')--}}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Shipment Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $shipment->date_of_shipment }}{{-- ->format('M d, Y H:i')--}}
                                    </dd>
                                </div>
                                @if($shipment->actual_delivery)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Actual Delivery</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $shipment->actual_delivery}}{{-- ->format('M d, Y H:i')--}}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    {{-- Shipment Route Timeline --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Tracking History</h3>
                        <div class="relative">
                            <div class="absolute top-0 left-5 h-full w-0.5 bg-gray-200"></div>
                            <div class="space-y-8">
                                @foreach($shipment->routes->sortByDesc('order') as $route)
                                    <div class="relative">
                                        <div class="flex items-start">
                                            <div class="relative flex items-center justify-center">
                                                <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                                    @if($route->status === 'arrived')
                                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    @elseif($route->status === 'pending')
                                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 ml-4">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $route->location }}</p>
                                                    <p class="text-sm text-gray-500">{{ $route->arrival_date}}</p>{{-- ->format('M d, Y H:i')--}}
                                                </div>
                                                @if($route->notes)
                                                    <p class="mt-2 text-sm text-gray-500">{{ $route->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
