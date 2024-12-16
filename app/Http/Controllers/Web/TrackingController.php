<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Show the tracking form
     */
    public function showForm()
    {
        return view('tracking.form');
    }

    /**
     * Track a shipment
     */
    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|min:8|max:30'
        ]);

        $trackingNumber = strtoupper($request->tracking_number);


        $shipment = Shipment::with(['routes' => function ($query) {
            $query->orderBy('arrival_date', 'desc');
        }])
            ->where('tracking_number', $trackingNumber)
            ->first();

        if (!$shipment) {
            return back()
                ->withInput()
                ->withErrors(['tracking_number' => 'No shipment found with this tracking number.']);
        }

        return redirect()->route('tracking.show', $trackingNumber);
    }

    /**
     * Show the tracking details
     */
    public function show($trackingNumber)
    {
        $shipment = Shipment::with(['routes' => function ($query) {
            $query->orderBy('arrival_date', 'desc');
        }])
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        // Get current location and status
        $currentStatus = $this->trackingService->getCurrentStatus($shipment);
        return view('tracking.show', compact('shipment','currentStatus'));
    }

    /**
     * Get real-time updates for a shipment (AJAX endpoint)
     */
    public function getUpdates($trackingNumber)
    {
        $shipment = Shipment::where('tracking_number', $trackingNumber)->firstOrFail();

        return response()->json([
            'current_location' => $shipment->current_location,
            'status' => $shipment->status,
            'last_updated' => $shipment->updated_at->diffForHumans(),
        ]);
    }

    /**
     * Subscribe to shipment notifications
     */
    public function subscribeToUpdates(Request $request, $trackingNumber)
    {
        $request->validate([
            'email' => 'required|email',
            'notification_type' => 'required|array',
            'notification_type.*' => 'in:email,sms,push'
        ]);

        $shipment = Shipment::where('tracking_number', $trackingNumber)->firstOrFail();

        $this->trackingService->subscribeToUpdates(
            $shipment,
            $request->email,
            $request->notification_type
        );

        return back()->with('success', 'You have been subscribed to shipment updates successfully.');
    }

    /**
     * Report an issue with a shipment
     */
    public function reportIssue(Request $request, $trackingNumber)
    {
        $request->validate([
            'issue_type' => 'required|in:delay,damage,loss,other',
            'description' => 'required|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20'
        ]);

        $shipment = Shipment::where('tracking_number', $trackingNumber)->firstOrFail();

        $this->trackingService->reportIssue(
            $shipment,
            $request->issue_type,
            $request->description,
            $request->contact_email,
            $request->contact_phone
        );

        return back()->with('success', 'Your issue has been reported successfully. Our team will contact you shortly.');
    }

    /**
     * Get shipment route map
     */
    public function getRouteMap($trackingNumber)
    {
        $shipment = Shipment::where('tracking_number', $trackingNumber)
            ->with('routes')
            ->firstOrFail();

        $mapData = $this->trackingService->generateRouteMap($shipment);

        return response()->json($mapData);
    }


}
