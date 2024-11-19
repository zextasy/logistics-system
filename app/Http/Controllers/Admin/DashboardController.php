<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Shipment, Quote, Document};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
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

        return view('admin.dashboard', compact('metrics', 'recentActivity', 'chartData'));
    }

    private function calculateMonthlyRevenue()
    {
        return Shipment::whereMonth('created_at', Carbon::now()->month)
            ->sum('declared_value');
    }

    private function getShipmentChartData()
    {
        return Shipment::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->get();
    }

    private function getRevenueChartData()
    {
        return Shipment::selectRaw('DATE(created_at) as date, SUM(declared_value) as total')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->get();
    }
}
