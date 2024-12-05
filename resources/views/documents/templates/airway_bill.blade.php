<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Airway Bill - {{ $reference }}</title>
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
    <h3>Consignee</h3>
    <p>{{ $shipment->receiver_name }}</p>
    <p>Phone: {{ $shipment->receiver_phone }}</p>
    <p>Email: {{ $shipment->receiver_email }}</p>
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
</body>
</html>
