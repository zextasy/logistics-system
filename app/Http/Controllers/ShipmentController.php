<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function showTrackingForm()
    {
        return view('tracking.form');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $shipment = Shipment::with('routes')
            ->where('tracking_number', $request->tracking_number)
            ->firstOrFail();

        return view('tracking.result', compact('shipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:air,sea',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'description' => 'required|string',
            'shipper_name' => 'required|string',
            'receiver_name' => 'required|string',
            'container_size' => 'required_if:type,sea',
            'service_type' => 'required|string'
        ]);

        $validated['tracking_number'] = 'TRK'.uniqid();
        $validated['status'] = 'pending';

        $shipment = Shipment::create($validated);

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment created successfully');
    }
}
