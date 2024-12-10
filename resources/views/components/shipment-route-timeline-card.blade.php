@props([
    /** @var \App\Models\Shipment */
    'shipment'
])

<div {{ $attributes->class(['bg-white shadow overflow-hidden sm:rounded-lg my-8 p-4']) }}>
    <h3 class="text-lg font-medium mb-4">Tracking History</h3>
    <div class="relative">
        <div class="absolute top-0 left-5 h-full w-0.5 bg-gray-200"></div>
        <div class="space-y-8">
            <div class="relative">
                <div class="flex items-start">
                    <div class="relative flex items-center justify-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                            @if($shipment->status->hasDeparted())
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            @else()
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="min-w-0 flex-1 ml-4">
                        <div>
                            <p class="font-medium text-gray-900">{{ $shipment->loading_port }}</p>
                            <p class="text-sm text-gray-500">{{ $shipment->date_of_shipment}}</p>{{-- ->format('M d, Y H:i')--}}
                        </div>
                    </div>
                </div>
            </div>
            @foreach($shipment->routes->sortByDesc('order') as $route)
                <div class="relative">
                    <div class="flex items-start">
                        <div class="relative flex items-center justify-center">
                            <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                @if($route->status === \App\Enums\ShipmentRouteStatusEnum::ARRIVED)
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                @elseif($route->status === \App\Enums\ShipmentRouteStatusEnum::PENDING)
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
            <div class="relative">
                <div class="flex items-start">
                    <div class="relative flex items-center justify-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                            @if($shipment->status->hasArrived())
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            @else()
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="min-w-0 flex-1 ml-4">
                        <div>
                            <p class="font-medium text-gray-900">{{ $shipment->discharge_port }}</p>
                            <p class="text-sm text-gray-500">{{ $shipment->actual_delivery ?? $shipment->estimated_delivery}}</p>{{-- ->format('M d, Y H:i')--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
