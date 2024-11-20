<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Services\{ShipmentService, NotificationService};
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    protected $shipmentService;
    protected $notificationService;

    public function __construct(
        ShipmentService $shipmentService,
        NotificationService $notificationService
    ) {
        $this->shipmentService = $shipmentService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $shipments = auth()->user()->shipments()
            ->with(['routes', 'documents'])
            ->when($request->search, function($query, $search) {
                $query->where('tracking_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        $shipment->load(['routes', 'documents']);

        return view('shipments.show', compact('shipment'));
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $shipment = Shipment::with('routes')
            ->where('tracking_number', $request->tracking_number)
            ->firstOrFail();

        return view('shipments.track', compact('shipment'));
    }

    public function documents(Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        $documents = $shipment->documents()
            ->where('status', 'active')
            ->get();

        return view('shipments.documents', compact('shipment', 'documents'));
    }

    public function downloadDocument(Shipment $shipment, $documentId)
    {
        $this->authorize('view', $shipment);

        $document = $shipment->documents()->findOrFail($documentId);

        if ($document->status !== 'active') {
            return back()->with('error', 'This document is no longer active.');
        }

        return response()->download(storage_path("app/{$document->file_path}"));
    }
}
