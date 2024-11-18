<?php

namespace App\Services;

use App\Models\{Shipment, Quote, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    /**
     * Generate shipments report
     */
    public function getShipmentsReport($startDate, $endDate = null)
    {
        $endDate = $endDate ?? now();

        return Shipment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('COUNT(CASE WHEN status = "delivered" THEN 1 END) as delivered'),
            DB::raw('COUNT(CASE WHEN status = "in_transit" THEN 1 END) as in_transit'),
            DB::raw('AVG(CASE WHEN actual_delivery IS NOT NULL
                THEN TIMESTAMPDIFF(HOUR, created_at, actual_delivery)
                END) as avg_delivery_time')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Generate revenue report
     */
    public function getRevenueReport($startDate, $endDate = null)
    {
        $endDate = $endDate ?? now();

        return Shipment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(declared_value) as total_value'),
            DB::raw('COUNT(*) as shipment_count'),
            DB::raw('AVG(declared_value) as average_value')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Generate customer report
     */
    public function getCustomerReport($startDate, $endDate = null)
    {
        $endDate = $endDate ?? now();

        return User::select(
            'users.id',
            'users.name',
            'users.email',
            DB::raw('COUNT(DISTINCT shipments.id) as shipment_count'),
            DB::raw('COUNT(DISTINCT quotes.id) as quote_count'),
            DB::raw('SUM(shipments.declared_value) as total_value')
        )
            ->leftJoin('shipments', 'users.id', '=', 'shipments.user_id')
            ->leftJoin('quotes', 'users.id', '=', 'quotes.user_id')
            ->whereBetween('users.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->having('shipment_count', '>', 0)
            ->orderByDesc('total_value')
            ->get();
    }

    /**
     * Generate performance metrics
     */
    public function getPerformanceMetrics($startDate, $endDate = null)
    {
        $endDate = $endDate ?? now();

        return [
            'shipments' => $this->getShipmentMetrics($startDate, $endDate),
            'quotes' => $this->getQuoteMetrics($startDate, $endDate),
            'revenue' => $this->getRevenueMetrics($startDate, $endDate),
            'customers' => $this->getCustomerMetrics($startDate, $endDate)
        ];
    }

    /**
     * Get shipment metrics
     */
    private function getShipmentMetrics($startDate, $endDate)
    {
        return [
            'total' => Shipment::whereBetween('created_at', [$startDate, $endDate])->count(),
            'delivered' => Shipment::where('status', 'delivered')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate($startDate, $endDate),
            'average_delivery_time' => $this->calculateAverageDeliveryTime($startDate, $endDate)
        ];
    }

    /**
     * Calculate on-time delivery rate
     */
    private function calculateOnTimeDeliveryRate($startDate, $endDate)
    {
        $delivered = Shipment::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $total = $delivered->count();
        if ($total === 0) return 0;

        $onTime = $delivered->where('actual_delivery', '<=', DB::raw('estimated_delivery'))
            ->count();

        return ($onTime / $total) * 100;
    }

    /**
     * Calculate average delivery time
     */
    private function calculateAverageDeliveryTime($startDate, $endDate)
    {
        return Shipment::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('actual_delivery')
            ->avg(DB::raw('TIMESTAMPDIFF(HOUR, created_at, actual_delivery)'));
    }
}
