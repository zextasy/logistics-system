{{-- resources/views/components/real-time-tracker.blade.php --}}
@props(['shipment'])

<div x-data="realTimeTracker()"
     x-init="startTracking()"
     class="bg-white rounded-lg shadow">
    <div class="p-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Live Tracking</h3>
            <span x-show="updating" class="flex items-center text-sm text-gray-500">
                <x-loading-indicator class="w-4 h-4 mr-2" />
                Updating...
            </span>
        </div>
    </div>
    <div class="p-4">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="bg-gray-50 px-4 py-5 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 truncate">Current Location</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900" x-text="currentLocation"></dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 rounded-lg">
                <dt class="text-sm font-medium text-gray-500 truncate">Status</dt>
                <dd class="mt-1">
                    <span x-text="status"
                          class="px-2 py-1 text-xs font-medium rounded-full"
                          :class="{
                              'bg-yellow-100 text-yellow-800': status === 'pending',
                              'bg-blue-100 text-blue-800': status === 'in_transit',
                              'bg-green-100 text-green-800': status === 'delivered'
                          }">
                    </span>
                </dd>
            </div>
        </dl>

        <!-- Latest Updates -->
        <div class="mt-6">
            <h4 class="text-sm font-medium text-gray-500">Latest Updates</h4>
            <div class="mt-2 flow-root">
                <ul role="list" class="-mb-8">
                    <template x-for="update in updates" :key="update.id">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white"
                                              :class="{
                                                  'bg-green-500': update.type === 'location',
                                                  'bg-blue-500': update.type === 'status',
                                                  'bg-yellow-500': update.type === 'delay'
                                              }">
                                            <svg class="h-5 w-5 text-white" x-bind:class="getIconClass(update.type)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-bind:d="getIconPath(update.type)"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500" x-text="update.message"></p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time x-text="formatDate(update.timestamp)"></time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function realTimeTracker() {
        return {
            currentLocation: '{{ $shipment->current_location }}',
            status: '{{ $shipment->status }}',
            updates: [],
            updating: false,
            pollingInterval: null,

            startTracking() {
                this.fetchUpdates();
                this.pollingInterval = setInterval(() => this.fetchUpdates(), 30000); // Poll every 30 seconds
            },

            async fetchUpdates() {
                this.updating = true;
                try {
                    const response = await fetch(`/api/shipments/{{ $shipment->tracking_number }}/updates`);
                    const data = await response.json();

                    this.currentLocation = data.current_location;
                    this.status = data.status;
                    this.updates = data.updates;
                } catch (error) {
                    console.error('Failed to fetch updates:', error);
                } finally {
                    this.updating = false;
                }
            },

            formatDate(timestamp) {
                return new Date(timestamp).toLocaleString();
            },

            getIconClass(type) {
                return {
                    'location': 'h-6 w-6',
                    'status': 'h-5 w-5',
                    'delay': 'h-5 w-5'
                }[type] || 'h-5 w-5';
            },

            getIconPath(type) {
                return {
                    'location': 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z',
                    'status': 'M13 10V3L4 14h7v7l9-11h-7z',
                    'delay': 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                }[type] || '';
            }
        }
    }
</script>
