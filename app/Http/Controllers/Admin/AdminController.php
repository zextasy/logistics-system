<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Quote, Shipment};
use App\Services\{DocumentGenerationService};
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $documentService;

    public function __construct(
        DocumentGenerationService $documentService
    ) {
        $this->documentService = $documentService;
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
            'total_quotes' => Quote::count(),
        ];

        $recentActivity = [
            'shipments' => Shipment::with(['user', 'routes'])
                ->latest()
                ->take(5)
                ->get(),
            'quotes' => Quote::with('assignedTo')
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

}
