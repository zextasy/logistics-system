{{-- resources/views/components/tracking-timeline.blade.php --}}
@props(['routes'])

<div class="relative">
    <div class="absolute top-0 left-5 h-full w-0.5 bg-gray-200"></div>

    <div class="space-y-8">
        @foreach($routes as $route)
            <div class="relative">
                <div class="flex items-center">
                    <div class="absolute flex items-center justify-center w-10 h-10">
                        <div class="w-10 h-10 bg-{{ $route->status === 'departed' ? 'green' : ($route->status === 'arrived' ? 'blue' : 'gray') }}-100 rounded-full flex items-center justify-center">
                            @if($route->status === 'departed')
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($route->status === 'arrived')
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="ml-16">
                        <h3 class="text-lg font-medium text-gray-900">{{ $route->location }}</h3>
                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $route->arrival_date->format('M d, Y H:i') }}
                            </div>
                            @if($route->departure_date)
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $route->departure_date->format('M d, Y H:i') }}
                                </div>
                            @endif
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





