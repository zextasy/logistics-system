<?php

// app/Services/ReportingService.php
namespace App\Services;

use App\Models\{Shipment, Quote, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Excel;

class ReportingService
{
    public function generateReport(string $type, string $dateRange)
    {
        $startDate = $this->getStartDate($dateRange);

        return match($type) {
            'shipments' => $this->getShipmentsReport($startDate),
            'revenue' => $this->getRevenueReport($startDate),
            'customers' => $this->getCustomerReport($startDate),
            default => throw new \InvalidArgumentException("Invalid report type: {$type}")
        };
    }

    public function exportReport(string $type, string $dateRange)
    {
        $data = $this->generateReport($type, $dateRange);

        return Excel::download(
            new ReportExport($data, $type),
            "{$type}_report_{$dateRange}.xlsx"
        );
    }

    public function generateCustomReport(string $startDate, string $endDate, array $metrics)
    {
        $data = [];

        foreach ($metrics as $metric) {
            $data[$metric] = match($metric) {
                'shipments_count' => $this->getShipmentsCount($startDate, $endDate),
                'revenue' => $this->getRevenue($startDate, $endDate),
                'average_delivery_time' => $this->getAverageDeliveryTime($startDate, $endDate),
                'customer_satisfaction' => $this->getCustomerSatisfaction($startDate, $endDate),
                default => null
            };
        }

        return $data;
    }

    public function calculateMonthlyRevenue(): float
    {
        return Shipment::whereMonth('created_at', Carbon::now()->month)
            ->sum('declared_value');
    }

    protected function getShipmentsReport($startDate)
    {
        return Shipment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('COUNT(CASE WHEN status = "delivered" THEN 1 END) as delivered'),
            DB::raw('COUNT(CASE WHEN status = "on_transit" THEN 1 END) as on_transit'),
            DB::raw('AVG(CASE WHEN actual_delivery IS NOT NULL
                THEN TIMESTAMPDIFF(HOUR, created_at, actual_delivery)
                END) as avg_delivery_time')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get();
    }

    protected function getRevenueReport($startDate)
    {
        return Shipment::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(declared_value) as total_value'),
            DB::raw('COUNT(*) as shipment_count'),
            DB::raw('AVG(declared_value) as average_value')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->get();
    }

    protected function getCustomerReport($startDate)
    {
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
            ->where('users.created_at', '>=', $startDate)
            ->groupBy('users.id', 'users.name', 'users.email')
            ->having('shipment_count', '>', 0)
            ->get();
    }

    protected function getStartDate(string $range): Carbon
    {
        return match($range) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'quarter' => Carbon::now()->subQuarter(),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonth()
        };
    }

    /**
     * Get Shipment Chart Data
     */
    public function getShipmentChartData()
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
    public function getRevenueChartData()
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
