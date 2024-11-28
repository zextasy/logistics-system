<x-guest-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Shipment Details</h2>

                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tracking Number</p>
                            <p class="font-semibold">{{ $shipment->tracking_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-semibold">{{ ucfirst($shipment->status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Origin</p>
                            <p class="font-semibold">{{ $shipment->origin }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Destination</p>
                            <p class="font-semibold">{{ $shipment->destination }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    @foreach($shipment->routes as $route)
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">{{ $route->location }}</p>
                                <p class="text-sm text-gray-600">
                                    Arrival: {{ $route->arrival_date->format('M d, Y H:i') }}
                                </p>
                                @if($route->departure_date)
                                    <p class="text-sm text-gray-600">
                                        Departure: {{ $route->departure_date->format('M d, Y H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
