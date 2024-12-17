<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill of Lading - {{ $reference }}</title>
    <style>
        /* Add your PDF styling here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>BILL OF LADING</h1>
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
{{--    <h3>Vessel Details</h3>--}}
{{--    <p>Vessel Name: {{ $data['vessel_name'] }}</p>--}}
{{--    <p>Voyage Number: {{ $data['voyage_number'] }}</p>--}}
{{--    <p>Port of Loading: {{ $data['port_of_loading'] }}</p>--}}
{{--    <p>Port of Discharge: {{ $data['port_of_discharge'] }}</p>--}}
{{--</div>--}}

{{--<div class="section">--}}
{{--    <h3>Container Details</h3>--}}
{{--    <p>Container Numbers: {{ $data['container_numbers'] }}</p>--}}
{{--    <p>Seal Numbers: {{ $data['seal_numbers'] }}</p>--}}
{{--</div>--}}

<div class="section">
    <h3>Cargo Details</h3>
    <p>Description: {{ $shipment->description }}</p>
    <p>Weight: {{ $shipment->weight .' '. $shipment->weight_unit}}</p>
</div>
</body>
</html>
