<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Services\{ShipmentService, DocumentGenerationService, NotificationService};
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    protected $shipmentService;
    protected $documentService;
    protected $notificationService;

    public function __construct(
        ShipmentService $shipmentService,
        DocumentGenerationService $documentService,
        NotificationService $notificationService
    ) {
        $this->shipmentService = $shipmentService;
        $this->documentService = $documentService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $shipments = Shipment::with(['user', 'routes', 'documents','originCountry','originCity','destinationCountry','destinationCity'])
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
        $countries = $this->shipmentService->getCountries();
        return view('admin.shipments.create', compact('countries'));
    }

    public function store(ShipmentRequest $request)
    {
        $shipment = $this->shipmentService->createShipment($request->validated());

        if ($request->generate_documents) {
            $this->documentService->generateInitialDocuments($shipment);
        }

//        $this->notificationService->sendShipmentCreatedNotification($shipment);

        return redirect()
            ->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment created successfully');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['routes', 'documents']);
        $countries = $this->shipmentService->getCountries();

        return view('admin.shipments.show', compact('shipment', 'countries'));
    }

    public function edit(Shipment $shipment)
    {
        $shipment->load(['routes', 'documents']);
        $countries = $this->shipmentService->getCountries();

        return view('admin.shipments.edit', compact('shipment', 'countries'));
    }
    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        $oldStatus = $shipment->status;

        $this->shipmentService->updateShipment($shipment, $request->validated());

        if ($oldStatus !== $shipment->status) {
//            $this->notificationService->sendShipmentStatusNotification($shipment, $oldStatus);
        }

        return redirect()
            ->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment updated successfully');
    }

    public function updateRoute(Request $request, Shipment $shipment, $routeId)
    {
        $request->validate([
            'status' => 'required|in:pending,arrived,departed,skipped',
            'actual_arrival_date' => 'nullable|date',
            'actual_departure_date' => 'nullable|date|after:actual_arrival_date',
            'notes' => 'nullable|string'
        ]);

        $this->shipmentService->updateRoute($shipment, $routeId, $request->all());

        return back()->with('success', 'Route updated successfully');
    }

    public function destroy(Shipment $shipment)
    {
        $this->shipmentService->deleteShipment($shipment);
        return redirect()
            ->route('admin.shipments.index')
            ->with('success', 'Shipment deleted successfully');
    }

}
