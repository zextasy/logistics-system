{{-- resources/views/admin/dashboard/index.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500">Total Shipments</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['total_shipments']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500">Active Shipments</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['active_shipments']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500">Total Quotes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['total_quotes']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-gray-500">Pending Quotes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['pending_quotes']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Recent Shipments --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Shipments</h3>
                        <a href="{{ route('admin.shipments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentActivity['shipments'] as $shipment)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $shipment->tracking_number }}</p>
                                    <p class="text-sm text-gray-500">{{ $shipment->origin_city_name }} → {{ $shipment->destination_city_name }}</p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $shipment->status->value === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $shipment->status->value === 'in_transit' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $shipment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ Str::title($shipment->status->value) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent shipments</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Quotes --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Quotes</h3>
                        <a href="{{ route('admin.quotes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentActivity['quotes'] as $quote)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $quote->company }}</p>
                                    <p class="text-sm text-gray-500">{{ $quote->service_type }}</p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $quote->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $quote->status === 'processed' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ Str::title($quote->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No recent quotes</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

