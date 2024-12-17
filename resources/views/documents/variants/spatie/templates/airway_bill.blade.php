<x-document-layout>
    <div class="header">
        <h1>AIRWAY BILL</h1>
        <h2>{{ $reference }}</h2>
    </div>

    <div class="section">
        <h3>Shipper</h3>
        <p>{{ $shipment->shipper_name }}</p>
        <p>Phone: {{ $shipment->shipper_phone }}</p>
        <p>Email: {{ $shipment->shipper_email }}</p>
    </div>

    <div class="section">
        <h3>Notify Party</h3>
        <p>{{ $shipment->notify_party_name }}</p>
        <p>Phone: {{ $shipment->notify_party_phone }}</p>
        <p>Email: {{ $shipment->notify_party_email }}</p>
    </div>

    {{--<div class="section">--}}
    {{--    <h3>Flight Details</h3>--}}
    {{--    <p>Flight Number: {{ $data['flight_number'] }}</p>--}}
    {{--    <p>From: {{ $data['airport_of_departure'] }}</p>--}}
    {{--    <p>To: {{ $data['airport_of_destination'] }}</p>--}}
    {{--</div>--}}

    <div class="section">
        <h3>Cargo Details</h3>
        <p>Description: {{ $shipment->description }}</p>
        <p>Weight: {{ $shipment->weight .' '. $shipment->weight_unit}}</p>
    </div>

    {{--<div class="section">--}}
    {{--    <h3>Special Handling</h3>--}}
    {{--    <p>{{ $data['special_handling'] ?? 'None' }}</p>--}}
    {{--</div>--}}
</x-document-layout>

