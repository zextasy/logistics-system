{{-- resources/views/welcome.blade.php --}}
<x-guest-layout>
    <!-- Hero Section -->
    <div class="relative bg-gray-50">
        <main class="lg:relative">
            <div class="mx-auto w-full max-w-7xl pt-16 pb-20 text-center lg:py-48 lg:text-left">
                <div class="px-4 sm:px-8 lg:w-1/2 xl:pr-16">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                        <span class="block xl:inline">Global Logistics</span>
                        <span class="block text-indigo-600 xl:inline">Made Simple</span>
                    </h1>
                    <p class="mx-auto mt-3 max-w-md text-lg text-gray-500 sm:text-xl md:mt-5 md:max-w-3xl">
                        Streamline your shipping process with our comprehensive logistics solutions. Track shipments, request quotes, and manage your cargo efficiently.
                    </p>
                    <div class="mt-10 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('tracking.form') }}"
                               class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 md:py-4 md:px-10 md:text-lg">
                                Track Shipment
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('quote.create') }}"
                               class="flex w-full items-center justify-center rounded-md border border-transparent bg-white px-8 py-3 text-base font-medium text-indigo-600 hover:bg-gray-50 md:py-4 md:px-10 md:text-lg">
                                Get a Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative h-64 w-full sm:h-72 md:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:h-full lg:w-1/2">
                <img class="absolute inset-0 h-full w-full object-cover"
                     src="{{ asset('images/hero-image.jpg') }}"
                     alt="Global Logistics">
            </div>
        </main>
    </div>

    <!-- Quick Track Section -->
    <div class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base font-semibold uppercase tracking-wide text-indigo-600">Track Your Shipment</h2>
                <p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Quick Tracking</p>
            </div>
            <div class="mt-10 max-w-xl mx-auto">
                <form action="{{ route('tracking.track') }}" method="POST" class="sm:flex">
                    @csrf
                    <div class="min-w-0 flex-1">
                        <label for="tracking_number" class="sr-only">Tracking Number</label>
                        <input type="text"
                               name="tracking_number"
                               id="tracking_number"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your tracking number">
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-3">
                        <button type="submit"
                                class="block w-full rounded-md bg-indigo-600 py-3 px-4 font-medium text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:px-10">
                            Track
                        </button>
                    </div>
                </form>
                @error('tracking_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="bg-gray-50 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base font-semibold uppercase tracking-wide text-indigo-600">Our Services</h2>
                <p class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                    Complete Logistics Solutions
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Choose from our range of shipping and logistics services designed to meet your needs.
                </p>
            </div>

            <div class="mt-20">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Air Freight -->
                    <div class="pt-6">
                        <div class="flow-root rounded-lg bg-white px-6 pb-8">
                            <div class="-mt-6">
                                <div class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-3 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l4 9h7l4-9M3 13h18M5 21l4-9M19 21l-4-9"/>
                                    </svg>
                                </div>
                                <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Air Freight</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Fast and reliable air freight services for time-sensitive shipments worldwide.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sea Freight -->
                    <div class="pt-6">
                        <div class="flow-root rounded-lg bg-white px-6 pb-8">
                            <div class="-mt-6">
                                <div class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-3 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Sea Freight</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Cost-effective ocean freight solutions for larger shipments and containers.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Customs Clearance -->
                    <div class="pt-6">
                        <div class="flow-root rounded-lg bg-white px-6 pb-8">
                            <div class="-mt-6">
                                <div class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-3 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Customs Clearance</h3>
                                <p class="mt-5 text-base text-gray-500">
                                    Expert handling of customs documentation and clearance procedures.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="mx-auto max-w-2xl py-16 px-4 text-center sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to get started?</span>
                <span class="block">Create an account today.</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Join thousands of businesses who trust us with their logistics needs.
            </p>
            <a href="{{ route('register') }}"
               class="mt-8 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-white px-5 py-3 text-base font-medium text-indigo-600 hover:bg-indigo-50 sm:w-auto">
                Sign up for free
            </a>
        </div>
    </div>
</x-guest-layout>

