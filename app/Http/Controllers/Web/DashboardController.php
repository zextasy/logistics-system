<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Shipment, Quote};

class DashboardController extends Controller
{
    public function index()
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

        return view('dashboard', compact('stats', 'recentShipments', 'recentQuotes'));
    }
}

