<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $shipments = Shipment::with(['user', 'routes', 'documents'])
            ->when($request->search, function($query, $search) {
                $query->where('tracking_number', 'like', "%{$search}%")
                    ->orWhere('shipper_name', 'like', "%{$search}%")
                    ->orWhere('receiver_name', 'like', "%{$search}%");
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date_from, function($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Shipment::count(),
            'in_transit' => Shipment::where('status', 'in_transit')->count(),
            'delivered' => Shipment::where('status', 'delivered')->count(),
            'pending' => Shipment::where('status', 'pending')->count(),
        ];

        return view('admin.shipments.index', compact('shipments', 'stats'));
    }

    public function create()
    {
        return view('admin.shipments.create');
    }

    public function store(ShipmentRequest $request)
    {
        $shipment = Shipment::create($request->validated());

        if ($request->has('routes')) {
            foreach ($request->routes as $route) {
                $shipment->routes()->create($route);
            }
        }

        $this->notificationService->sendShipmentCreatedNotification($shipment);

        return redirect()
            ->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment created successfully');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['routes', 'documents', 'user']);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $shipment->load(['routes', 'documents']);
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        $oldStatus = $shipment->status;

        $shipment->update($request->validated());

        if ($oldStatus !== $shipment->status) {
            $this->notificationService->sendShipmentStatusNotification($shipment, $oldStatus);
        }

        return redirect()
            ->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment updated successfully');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()
            ->route('admin.shipments.index')
            ->with('success', 'Shipment deleted successfully');
    }
}
