{{-- resources/views/admin/quotes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">Quote Requests</h2>
                <div class="flex space-x-3">
                    {{--                    <a href="{{ route('admin.quotes.export') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md">--}}
                    {{--                        <x-icon name="download" class="w-5 h-5 mr-2" />--}}
                    {{--                        Export--}}
                    {{--                    </a>--}}
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-12">

            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @foreach([
                    ['Pending', $stats['pending'], 'clock', 'bg-yellow-600'],
                    ['Processing', $stats['processing'], 'refresh', 'bg-blue-600'],
                    ['Approved', $stats['approved'], 'check', 'bg-green-600'],
                    ['Rejected', $stats['rejected'], 'x', 'bg-red-600']
                ] as [$label, $count, $icon, $color])
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="{{ $color }} rounded-full p-3">
{{--                                <x-icon :name="$icon" class="w-6 h-6 text-white" />--}}
                            </div>
                            <div class="ml-5">
                                <p class="text-gray-500">{{ $label }}</p>
                                <p class="text-2xl font-bold">{{ number_format($count) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <form action="{{ route('admin.quotes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                @foreach(['pending', 'processing', 'approved', 'rejected'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                            <select name="service_type" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Services</option>
                                @foreach(['air_freight', 'sea_freight', 'road_freight', 'rail_freight'] as $type)
                                    <option value="{{ $type }}" {{ request('service_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                            <select name="date_range" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quotes Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($quotes as $quote)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $quote->reference_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $quote->company }}</div>
                                <div class="text-sm text-gray-500">{{ $quote->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', $quote->service_type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $quote->origin_country }}</div>
                                <div class="text-sm text-gray-500">→ {{ $quote->destination_country }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $quote->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $quote->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $quote->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $quote->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $quote->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.quotes.show', $quote) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    View
                                </a>
{{--                                <a href="{{ route('admin.quotes.edit', $quote) }}" class="text-green-600 hover:text-green-900 mr-3">--}}
{{--                                    Process--}}
{{--                                </a>--}}
{{--                                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="inline-block">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit"--}}
{{--                                            class="text-red-600 hover:text-red-900"--}}
{{--                                            onclick="return confirm('Are you sure you want to delete this quote?')">--}}
{{--                                        Delete--}}
{{--                                    </button>--}}
{{--                                </form>--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No quotes found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="p-4 bg-white border-t border-gray-200">
                    {{ $quotes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
