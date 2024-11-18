<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Track Your Shipment</h2>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('tracking.track') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700">
                                Tracking Number
                            </label>
                            <div class="mt-1">
                                <input type="text"
                                       name="tracking_number"
                                       id="tracking_number"
                                       value="{{ old('tracking_number') }}"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Enter your tracking number">
                                @error('tracking_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Track Shipment
                            </button>
                        </div>
                    </form>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium mb-4">Recent Searches</h3>
                        <div class="space-y-4">
                            @forelse(session('recent_searches', []) as $search)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium">{{ $search['tracking_number'] }}</p>
                                        <p class="text-sm text-gray-500">Last checked: {{ $search['timestamp'] }}</p>
                                    </div>
                                    <a href="{{ route('tracking.show', $search['tracking_number']) }}"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        View Status
                                    </a>
                                </div>
                            @empty
                                <p class="text-gray-500">No recent searches</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

