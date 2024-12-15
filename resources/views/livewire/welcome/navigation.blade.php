<nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" aria-label="Top">
    <div class="flex w-full items-center justify-between border-b border-indigo-500 py-6">
        <div class="flex items-center">
            <a href="{{ route('home') }}">
                <span class="sr-only">{{ config('app.name') }}</span>
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
            <div class="ml-10 hidden space-x-8 lg:block">
                <a href="{{route('home')}}#services" class="text-base font-medium text-gray-700 hover:text-indigo-600">Services</a>
                <a href="{{route('home')}}#about" class="text-base font-medium text-gray-700 hover:text-indigo-600">About Us</a>
                <a href="{{route('home')}}#contact" class="text-base font-medium text-gray-700 hover:text-indigo-600">Contact</a>
                <a href="{{ route('tracking.form') }}" class="text-base font-medium text-gray-700 hover:text-indigo-600">Track Shipment</a>
                <a href="{{ route('quote.create') }}" class="text-base font-medium text-gray-700 hover:text-indigo-600">Get a quote</a>
            </div>
        </div>
        <div class="ml-10 space-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-block bg-indigo-600 py-2 px-4 border border-transparent rounded-md text-base font-medium text-white hover:bg-indigo-700">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-white py-2 px-4 border border-transparent rounded-md text-base font-medium text-indigo-600 hover:bg-gray-50">Sign in</a>
            @endauth
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-x-6 py-4 lg:hidden">
        <a href="{{route('home')}}#services" class="text-base font-medium text-gray-700 hover:text-indigo-600">Services</a>
        <a href="{{route('home')}}#about" class="text-base font-medium text-gray-700 hover:text-indigo-600">About Us</a>
        <a href="{{route('home')}}#contact" class="text-base font-medium text-gray-700 hover:text-indigo-600">Contact</a>
        <a href="{{route('tracking.form')}}#contact" class="text-base font-medium text-gray-700 hover:text-indigo-600">Track Shipment</a>
        <a href="{{route('quote.create')}}#contact" class="text-base font-medium text-gray-700 hover:text-indigo-600">Get a Quote</a>
    </div>
</nav>
