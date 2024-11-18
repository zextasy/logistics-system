{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside class="fixed inset-y-0 left-0 bg-indigo-800 w-64 transition-transform duration-150 ease-in transform md:translate-x-0 -translate-x-full md:relative" x-show="sidebarOpen">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-indigo-900">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-bold">
                Logistics Admin
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="home" :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-sidebar-link>

            <!-- Shipments -->
            <x-sidebar-dropdown title="Shipments" icon="truck" :active="request()->routeIs('admin.shipments.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.shipments.index') }}">
                    All Shipments
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.shipments.create') }}">
                    Create Shipment
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.shipments.pending') }}">
                    Pending Shipments
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.shipments.in-transit') }}">
                    In Transit
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>

            <!-- Quotes -->
            <x-sidebar-dropdown title="Quotes" icon="document-text" :active="request()->routeIs('admin.quotes.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.quotes.index') }}">
                    All Quotes
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.quotes.pending') }}">
                    Pending Quotes
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.quotes.processed') }}">
                    Processed Quotes
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>

            <!-- Documents -->
            <x-sidebar-dropdown title="Documents" icon="document" :active="request()->routeIs('admin.documents.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.documents.index') }}">
                    All Documents
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.documents.create') }}">
                    Generate Document
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>

            <!-- Users -->
            <x-sidebar-dropdown title="Users" icon="users" :active="request()->routeIs('admin.users.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.users.index') }}">
                    All Users
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.users.create') }}">
                    Create User
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>

            <!-- Reports -->
            <x-sidebar-dropdown title="Reports" icon="chart-bar" :active="request()->routeIs('admin.reports.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.reports.shipments') }}">
                    Shipment Reports
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.reports.revenue') }}">
                    Revenue Reports
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.reports.customers') }}">
                    Customer Reports
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>

            <!-- Settings -->
            <x-sidebar-dropdown title="Settings" icon="cog" :active="request()->routeIs('admin.settings.*')">
                <x-sidebar-dropdown-link href="{{ route('admin.settings.general') }}">
                    General Settings
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.settings.notifications') }}">
                    Notification Settings
                </x-sidebar-dropdown-link>
                <x-sidebar-dropdown-link href="{{ route('admin.settings.api') }}">
                    API Settings
                </x-sidebar-dropdown-link>
            </x-sidebar-dropdown>
        </nav>

        <!-- User Info -->
        <div class="p-4 bg-indigo-900">
            <div class="flex items-center">
                <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile" class="h-8 w-8 rounded-full">
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-indigo-200">
                        Administrator
                    </p>
                </div>
            </div>
        </div>
    </div>
</aside>

{{-- Sidebar Link Component --}}
@component('sidebar-link')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'group flex items-center px-2 py-2 text-sm font-medium rounded-md ' . ($active ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700')]) }}>
        <x-icon :name="$icon" class="mr-3 h-6 w-6 text-indigo-300"/>
        {{ $slot }}
    </a>
@endcomponent

{{-- Sidebar Dropdown Component --}}
@component('sidebar-dropdown')
    <div x-data="{ open: @json($active) }" class="space-y-1">
        <button @click="open = !open" class="w-full group flex items-center px-2 py-2 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-700">
            <x-icon :name="$icon" class="mr-3 h-6 w-6 text-indigo-300"/>
            {{ $title }}
            <x-icon name="chevron-down" class="ml-auto h-5 w-5 transform transition-transform duration-150" :class="{ 'rotate-180': open }"/>
        </button>
        <div x-show="open" class="pl-4 space-y-1">
            {{ $slot }}
        </div>
    </div>
@endcomponent
