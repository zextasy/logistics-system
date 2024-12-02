<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Shipments Management</h2>
            <a href="{{ route('admin.shipments.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Shipment
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6">
                    {{-- Contact Information --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <x-text-input :disabled="true" name="name">{{$quote->name}}</x-text-input>
                            </div>

                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700">Company Name</label>

                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>

                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>

                            </div>
                        </div>
                    </div>

                    {{-- Shipment Details --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipment Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>

                            </div>

                            <div>
                                <label for="cargo_type" class="block text-sm font-medium text-gray-700">Cargo Type</label>

                            </div>

                            <div>
                                <label for="origin_country" class="block text-sm font-medium text-gray-700">Origin Country</label>

                            </div>

                            <div>
                                <label for="destination_country" class="block text-sm font-medium text-gray-700">Destination Country</label>

                            </div>
                        </div>
                    </div>

                    {{-- Cargo Details --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cargo Details</h3>

                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Cargo Description</label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="estimated_weight" class="block text-sm font-medium text-gray-700">Weight</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">

                                    </div>
                                </div>

                                <div>
                                    <label for="pieces_count" class="block text-sm font-medium text-gray-700">Number of Pieces</label>

                                </div>

                                <div>
                                    <label for="container_size" class="block text-sm font-medium text-gray-700">Container Size</label>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Services --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Services</h3>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <label for="insurance_required" class="ml-2 block text-sm text-gray-900">
                                    Cargo Insurance Required
                                </label>
                            </div>

                            <div class="flex items-center">
                                <label for="customs_clearance_required" class="ml-2 block text-sm text-gray-900">
                                    Customs Clearance Required
                                </label>
                            </div>

                            <div class="flex items-center">
                                <label for="pickup_required" class="ml-2 block text-sm text-gray-900">
                                    Door Pickup Required
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Special Requirements --}}
                    <div class="mb-6">
                        <label for="special_requirements" class="block text-sm font-medium text-gray-700">Special Requirements</label>

                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
