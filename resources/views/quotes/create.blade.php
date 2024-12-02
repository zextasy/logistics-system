{{-- resources/views/quotes/create.blade.php --}}
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <form action="{{ route('quote.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Contact Information --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input type="text" name="company" id="company" value="{{ old('company') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Shipment Details --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipment Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                                <select name="service_type" id="service_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Service</option>
                                    <option value="air_freight">Air Freight</option>
                                    <option value="sea_freight">Sea Freight</option>
                                    <option value="road_freight">Road Freight</option>
                                    <option value="rail_freight">Rail Freight</option>
                                </select>
                                @error('service_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cargo_type" class="block text-sm font-medium text-gray-700">Cargo Type</label>
                                <select name="cargo_type" id="cargo_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="general">General Cargo</option>
                                    <option value="hazardous">Hazardous</option>
                                    <option value="perishable">Perishable</option>
                                    <option value="fragile">Fragile</option>
                                    <option value="valuable">Valuable</option>
                                </select>
                            </div>

                            <div>
                                <label for="origin_country" class="block text-sm font-medium text-gray-700">Origin Country</label>
                                <select name="origin_country" id="origin_country" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($countries as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="destination_country" class="block text-sm font-medium text-gray-700">Destination Country</label>
                                <select name="destination_country" id="destination_country" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($countries as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Cargo Details --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cargo Details</h3>

                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Cargo Description</label>
                                <textarea name="description" id="description" rows="3" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="estimated_weight" class="block text-sm font-medium text-gray-700">Weight</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="estimated_weight" id="estimated_weight"
                                               value="{{ old('estimated_weight') }}" step="0.01" required
                                               class="flex-1 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <select name="weight_unit"
                                                class="rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="kg">KG</option>
                                            <option value="lbs">LBS</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="pieces_count" class="block text-sm font-medium text-gray-700">Number of Pieces</label>
                                    <input type="number" name="pieces_count" id="pieces_count"
                                           value="{{ old('pieces_count') }}" min="1" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="container_size" class="block text-sm font-medium text-gray-700">Container Size</label>
                                    <select name="container_size" id="container_size"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Not Applicable</option>
                                        <option value="LCL">LCL</option>
                                        <option value="20ft">20ft Container</option>
                                        <option value="40ft">40ft Container</option>
                                        <option value="40ft_hc">40ft High Cube</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Services --}}
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Services</h3>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="insurance_required" id="insurance_required"
                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="insurance_required" class="ml-2 block text-sm text-gray-900">
                                    Cargo Insurance Required
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="customs_clearance_required" id="customs_clearance_required"
                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="customs_clearance_required" class="ml-2 block text-sm text-gray-900">
                                    Customs Clearance Required
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="pickup_required" id="pickup_required"
                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="pickup_required" class="ml-2 block text-sm text-gray-900">
                                    Door Pickup Required
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Special Requirements --}}
                    <div class="mb-6">
                        <label for="special_requirements" class="block text-sm font-medium text-gray-700">Special Requirements</label>
                        <textarea name="special_requirements" id="special_requirements" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('special_requirements') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Submit Quote Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
