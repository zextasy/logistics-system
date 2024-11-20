<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Shipment, Quote, Document};
use App\Services\ReportingService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $reportingService;

    public function __construct(ReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    public function index()
    {
        $metrics = [
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'monthly_revenue' => $this->reportingService->calculateMonthlyRevenue(),
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
            'shipments' => $this->reportingService->getShipmentChartData(),
            'revenue' => $this->reportingService->getRevenueChartData(),
        ];

        return view('admin.dashboard', compact('metrics', 'recentActivity', 'chartData'));
    }
}
