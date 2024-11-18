<!DOCTYPE html>
<html>
<head>
    <title>Airway Bill</title>
    <style>
        /* Add your PDF styling here */
        .container { padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        .row { display: flex; margin-bottom: 10px; }
        .label { font-weight: bold; width: 150px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Airway Bill</h1>
        <h2>{{ $shipment->tracking_number }}</h2>
    </div>

    <div class="details">
        <div class="row">
            <span class="label">Shipper:</span>
            <span>{{ $shipment->shipper_name }}</span>
        </div>
        <div class="row">
            <span class="label">Receiver:</span>
            <span>{{ $shipment->receiver_name }}</span>
        </div>
        <div class="row">
            <span class="label">Origin:</span>
            <span>{{ $shipment->origin }}</span>
        </div>
        <div class="row">
            <span class="label">Destination:</span>
            <span>{{ $shipment->destination }}</span>
        </div>
        <div class="row">
            <span class="label">Description:</span>
            <span>{{ $shipment->description }}</span>
        </div>
    </div>
</div>
</body>
</html>
