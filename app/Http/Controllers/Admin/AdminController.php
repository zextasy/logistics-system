<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Shipment, Quote, Document};
use App\Http\Requests\{
    ShipmentRequest,
    QuoteUpdateRequest,
    DocumentRequest,
    UserUpdateRequest
};
use App\Services\{DocumentGenerationService, NotificationService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $documentService;
    protected $notificationService;

    public function __construct(
        DocumentGenerationService $documentService,
        NotificationService $notificationService
    ) {
        $this->documentService = $documentService;
        $this->notificationService = $notificationService;
//        $this->middleware('admin');
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $metrics = [
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'monthly_revenue' => $this->calculateMonthlyRevenue(),
        ];

        $recentActivity = [
            'shipments' => Shipment::with(['user', 'routes'])
                ->latest()
                ->take(5)
                ->get(),
            'quotes' => Quote::with('user')
                ->latest()
                ->take(5)
                ->get(),
            'documents' => Document::with(['shipment', 'shipment.user'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        $chartData = [
            'shipments' => $this->getShipmentChartData(),
            'revenue' => $this->getRevenueChartData(),
        ];

        return view('admin.dashboard.index', compact('metrics', 'recentActivity', 'chartData'));
    }

    /**
     * Manage Shipments
     */
    public function shipments(Request $request)
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

    /**
     * Manage Quotes
     */
    public function quotes(Request $request)
    {
        $quotes = Quote::with('user')
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->service_type, function ($query, $type) {
                $query->where('service_type', $type);
            })
            ->when($request->date_range, function ($query, $range) {
                if ($range === 'today') {
                    $query->whereDate('created_at', Carbon::today());
                } elseif ($range === 'week') {
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
            })
            ->latest()
            ->paginate(15);
        $stats = [
            'pending' => Quote::where('status', 'pending')->count(),
            'processing' => Quote::where('status', 'processing')->count(),
            'approved' => Quote::where('status', 'approved')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
        ];
        return view('admin.quotes.index', compact('quotes', 'stats'));
    }

    /**
     * Process Quote
     */
    public function processQuote(QuoteUpdateRequest $request, Quote $quote)
    {
        DB::transaction(function() use ($request, $quote) {
            $quote->update([
                'status' => $request->status,
                'quoted_price' => $request->quoted_price,
                'admin_notes' => $request->admin_notes,
                'processed_at' => now(),
                'valid_until' => $request->valid_until,
                'assigned_to' => auth()->id(),
            ]);

            if ($request->status === 'processed') {
                $this->notificationService->sendQuoteProcessedNotification($quote);
            }
        });

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote processed successfully');
    }

    /**
     * Manage Documents
     */
    public function documents(Request $request)
    {
        $documents = Document::with(['shipment', 'shipment.user'])
            ->when($request->type, function($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Generate Document
     */
    public function generateDocument(DocumentRequest $request)
    {
        $document = DB::transaction(function() use ($request) {
            $generatedDoc = $this->documentService->generate(
                $request->shipment_id,
                $request->type,
                $request->metadata ?? []
            );

            if ($request->notify_customer) {
                $this->notificationService->sendDocumentGeneratedNotification($generatedDoc);
            }

            return $generatedDoc;
        });

        return redirect()
            ->route('admin.documents.show', $document)
            ->with('success', 'Document generated successfully');
    }

    /**
     * Manage Users
     */
    public function users(Request $request)
    {
        $users = User::withCount(['shipments', 'quotes'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update User
     */
    public function updateUser(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with('success', 'User updated successfully');
    }

    /**
     * Reports & Analytics
     */
    public function reports(Request $request)
    {
        $type = $request->type ?? 'shipments';
        $dateRange = $request->date_range ?? 'month';
        $startDate = $this->getReportStartDate($dateRange);

        $data = match($type) {
            'shipments' => $this->getShipmentsReport($startDate),
            'revenue' => $this->getRevenueReport($startDate),
            'customers' => $this->getCustomerReport($startDate),
            default => $this->getShipmentsReport($startDate),
        };

        return view('admin.reports.index', compact('data', 'type', 'dateRange'));
    }

    /**
     * Export Report
     */
    public function exportReport(Request $request)
    {
        $type = $request->type ?? 'shipments';
        $dateRange = $request->date_range ?? 'month';
        $startDate = $this->getReportStartDate($dateRange);

        $data = match($type) {
            'shipments' => $this->getShipmentsReport($startDate),
            'revenue' => $this->getRevenueReport($startDate),
            'customers' => $this->getCustomerReport($startDate),
            default => $this->getShipmentsReport($startDate),
        };

        return Excel::download(
            new ReportExport($data, $type),
            "{$type}_report_{$dateRange}.xlsx"
        );
    }

    /**
     * Calculate Monthly Revenue
     */
    private function calculateMonthlyRevenue()
    {
        return Shipment::whereMonth('created_at', Carbon::now()->month)
            ->sum('declared_value');
    }

    /**
     * Get Shipment Chart Data
     */
    private function getShipmentChartData()
    {
        return Shipment::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total,
                ];
            });
    }

    /**
     * Get Revenue Chart Data
     */
    private function getRevenueChartData()
    {
        return Shipment::selectRaw('DATE(created_at) as date, SUM(declared_value) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total,
                ];
            });
    }

    /**
     * Get Report Start Date
     */
    private function getReportStartDate($range)
    {
        return match($range) {
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'quarter' => Carbon::now()->subQuarter(),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonth(),
        };
    }
}
