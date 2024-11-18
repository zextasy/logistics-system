<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Shipment Details</h2>
                        <span class="px-4 py-2 rounded-full text-sm
                            @if($shipment->status === 'delivered')
                                bg-green-100 text-green-800
                            @elseif($shipment->status === 'in_transit')
                                bg-blue-100 text-blue-800
                            @elseif($shipment->status === 'pending')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst($shipment->status) }}
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
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($shipment->service_type) }}</dd>
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

                    {{-- Subscribe to Updates --}}
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Subscribe to Updates</h3>
                        <form action="#" method="POST" class="space-y-4"> {{-- {{ route('tracking.subscribe', $shipment->tracking_number) }}--}}
                            @csrf
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Notification Type</label>
                                <div class="space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="notification_type[]" value="email" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2">Email</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="notification_type[]" value="sms" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2">SMS</span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Subscribe to Updates
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
