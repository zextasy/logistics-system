{{-- resources/views/components/quote-summary-card.blade.php --}}
@props(['quote'])

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Quote Summary
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Reference: {{ $quote->reference_number }}
        </p>
    </div>

    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
        <div class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <x-status-badge :status="$quote->status" />
                </dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ Str::title(str_replace('_', ' ', $quote->service_type)) }}
                </dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Route</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ $quote->origin_city }}, {{ $quote->origin_country }} →
                    {{ $quote->destination_city }}, {{ $quote->destination_country }}
                </dd>
            </div>

            @if($quote->quoted_price)
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Quoted Price</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ number_format($quote->quoted_price, 2) }} {{ $quote->currency }}
                    </dd>
                </div>
            @endif

            @if($quote->valid_until)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Valid Until</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $quote->valid_until->format('M d, Y H:i') }}
                    </dd>
                </div>
            @endif
        </div>
    </div>
</div>
