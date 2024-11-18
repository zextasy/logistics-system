{{-- resources/views/admin/shipments/index.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Shipments</h2>
                <a href="{{ route('admin.shipments.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
{{--                    <x-icon name="plus" class="w-5 h-5 mr-2" />--}}
                    New Shipment
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @foreach([
                    ['Total', $stats['total'], 'clipboard-list', 'bg-indigo-600'],
                    ['In Transit', $stats['in_transit'], 'truck', 'bg-yellow-600'],
                    ['Delivered', $stats['delivered'], 'check-circle', 'bg-green-600'],
                    ['Pending', $stats['pending'], 'clock', 'bg-gray-600']
                ] as [$label, $value, $icon, $color])
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="{{ $color }} rounded-full p-3">
{{--                                <x-icon :name="$icon" class="w-6 h-6 text-white" />--}}
                            </div>
                            <div class="ml-5">
                                <p class="text-gray-500">{{ $label }}</p>
                                <p class="text-2xl font-bold">{{ number_format($value) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <form action="{{ route('admin.shipments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Tracking number, shipper...">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                @foreach(['pending', 'in_transit', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                            <input type="date"
                                   name="date_from"
                                   value="{{ request('date_from') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                            <input type="date"
                                   name="date_to"
                                   value="{{ request('date_to') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Shipments Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($shipments as $shipment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $shipment->tracking_number }}</div>
                                <div class="text-sm text-gray-500">{{ $shipment->type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $shipment->origin }}</div>
                                <div class="text-sm text-gray-500">→ {{ $shipment->destination }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $shipment->shipper_name }}</div>
                                <div class="text-sm text-gray-500">{{ $shipment->receiver_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $shipment->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $shipment->status === 'in_transit' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $shipment->status === 'pending' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $shipment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $shipment->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.shipments.show', $shipment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                <a href="{{ route('admin.shipments.edit', $shipment) }}" class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                                <form action="{{ route('admin.shipments.destroy', $shipment) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this shipment?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No shipments found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4 bg-white border-t border-gray-200">
                    {{ $shipments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
