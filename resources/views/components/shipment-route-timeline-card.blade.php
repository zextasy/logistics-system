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
                                <svg class="h-6 w-6 text-white" fill="#FFFFFF"  viewBox="0 0 330 330" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="XMLID_30_" d="M154.394,325.606C157.322,328.535,161.161,330,165,330s7.678-1.465,10.607-4.394l75-75 c5.858-5.857,5.858-15.355,0-21.213c-5.858-5.857-15.356-5.857-21.213,0L180,278.787V15c0-8.284-6.716-15-15-15 c-8.284,0-15,6.716-15,15v263.787l-49.394-49.394c-5.858-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213 L154.394,325.606z"></path> </g></svg>
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
                            <p class="font-medium text-gray-900">{{ strtoupper($shipment->loading_port) }}</p>
                            <p class="text-sm text-gray-500">{{ $shipment->date_of_shipment->toFormattedDateString()}}</p>{{-- ->format('M d, Y H:i')--}}
                        </div>
                    </div>
                </div>
            </div>
            @foreach($shipment->routes->sortBy('arrival_date') as $route)
                <div class="relative">
                    <div class="flex items-start">
                        <div class="relative flex items-center justify-center">
                            <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                @if($route->status->hasDeparted())
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
                                <p class="font-medium text-gray-900">{{ strtoupper($route->location) }}</p>
                                <p class="text-sm text-gray-500">{{ $route->arrival_date->toFormattedDateString()}}</p>{{-- ->format('M d, Y H:i')--}}
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
                            <p class="font-medium text-gray-900">{{ strtoupper($shipment->discharge_port) }}</p>
                            <p class="text-sm text-gray-500">{{ isset($shipment->actual_delivery) ? $shipment->actual_delivery->toFormattedDateString() : $shipment->estimated_delivery->toFormattedDateString()}}</p>{{-- ->format('M d, Y H:i')--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="relative">
    <div class="flex items-start">
        <div class="flex justify-between items-center mb-6">
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
    </div>
</div>
