{{-- resources/views/components/shipment-details-card.blade.php --}}
@props(['shipment'])

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Shipment Details
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Tracking Number: {{ $shipment->tracking_number }}
        </p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Package Details</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Weight: {{ $shipment->weight }} {{ $shipment->weight_unit }}<br>
                    @if($shipment->dimensions)
                        Dimensions: {{ $shipment->dimensions_summarized }}<br>
                    @endif
                    @if($shipment->container_size)
                        Container Size: {{ $shipment->container_size }}<br>
                    @endif
                    Description of Goods: {{ $shipment->description }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Origin</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $shipment->origin_address }}<br>
                    {{ $shipment->origin_city_name }}, {{ $shipment->origin_country_name }}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Destination</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($shipment->final_place_for_delivery)
                        {{ $shipment->final_place_for_delivery }}<br>
                    @endif
                    {{ $shipment->destination_address }}<br>
                    {{ $shipment->destination_city_name }}, {{ $shipment->destination_country_name }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Shipper</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $shipment->shipper_name }}<br>
                    @if($shipment->shipper_phone)
                        Phone: {{ $shipment->shipper_phone }}<br>
                    @endif
                    @if($shipment->shipper_email)
                        Email: {{ $shipment->shipper_email }}
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Receiver</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $shipment->receiver_name }}<br>
                    @if($shipment->receiver_phone)
                        Phone: {{ $shipment->receiver_phone }}<br>
                    @endif
                    @if($shipment->receiver_email)
                        Email: {{ $shipment->receiver_email }}
                    @endif
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Consignee</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $shipment->consignee_name }}<br>
                    @if($shipment->consignee_phone)
                        Phone: {{ $shipment->consignee_phone }}<br>
                    @endif
                    @if($shipment->consignee_email)
                        Email: {{ $shipment->consignee_email }}
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Schedule</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($shipment->date_of_shipment)
                        Date of Shipment: {{ $shipment->date_of_shipment }}<br>
                    @endif
                        Estimated Delivery: {{ $shipment->estimated_delivery }}<br>
                    @if($shipment->actual_delivery)
                        Actual Delivery: {{ $shipment->actual_delivery }}<br>
                    @endif
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Extra Information</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Type: {{ $shipment->type->value}}<br>
                    Service Type: {{ $shipment->service_type->value}}<br>
                    @if($shipment->declared_value)
                        Declared Value: {{ $shipment->currency }} {{ $shipment->declared_value }}<br>
                    @endif
                    @if($shipment->charges)
{{--                        Charges: {{ $shipment->charges_in_html }}<br>--}}
                    @endif
                    @if($shipment->insurance_required)
                        Insurance: {{ $shipment->insurance_amount }}
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>
