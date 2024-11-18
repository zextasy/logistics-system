<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Stats Cards -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900">Total Shipments</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_shipments'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900">Active Shipments</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['active_shipments'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900">Pending Quotes</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_quotes'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Shipments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Shipments</h3>
                    <div class="space-y-4">
                        @foreach($stats['recent_shipments'] as $shipment)
                            <div class="border-b pb-2">
                                <p class="font-medium">{{ $shipment->tracking_number }}</p>
                                <p class="text-sm text-gray-600">{{ $shipment->origin }} → {{ $shipment->destination }}</p>
                                <p class="text-sm text-gray-600">Status: {{ ucfirst($shipment->status) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Quotes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Quote Requests</h3>
                    <div class="space-y-4">
                        @foreach($stats['recent_quotes'] as $quote)
                            <div class="border-b pb-2">
                                <p class="font-medium">{{ $quote->company }}</p>
                                <p class="text-sm text-gray-600">{{ $quote->service_type }}</p>
                                <p class="text-sm text-gray-600">Status: {{ ucfirst($quote->status) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
