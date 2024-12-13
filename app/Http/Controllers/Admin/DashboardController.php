<?php

// app/Http/Controllers/Admin/DashboardController.php
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
            'documents' => Document::with(['shipment', 'shipment.user'])
                ->latest()
                ->take(5)
                ->get(),
        ];


        return view('admin.dashboard', compact('metrics', 'recentActivity'));
    }
}
