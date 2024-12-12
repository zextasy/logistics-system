<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Shipment, Quote};

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'total_quotes' => Quote::count(),
        ];

        return view('dashboard', compact('metrics'));
    }
    public function user()
    {
        $user = auth()->user();

        $stats = [
            'active_shipments' => $user->shipments()
                ->whereNotIn('status', ['delivered', 'cancelled'])
                ->count(),
            'delivered_shipments' => $user->shipments()
                ->where('status', 'delivered')
                ->count(),
            'pending_quotes' => $user->quotes()
                ->where('status', 'pending')
                ->count()
        ];

        $recentShipments = $user->shipments()
            ->with('routes')
            ->latest()
            ->take(5)
            ->get();

        $recentQuotes = $user->quotes()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentShipments', 'recentQuotes'));
    }
}

