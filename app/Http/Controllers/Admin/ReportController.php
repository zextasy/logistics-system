<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportingService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportingService;

    public function __construct(ReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    public function index(Request $request)
    {
        $type = $request->type ?? 'shipments';
        $dateRange = $request->date_range ?? 'month';

        $data = $this->reportingService->generateReport($type, $dateRange);
        $metrics = $this->reportingService->getPerformanceMetrics($dateRange);

        return view('admin.reports.index', compact('data', 'metrics', 'type', 'dateRange'));
    }

    public function export(Request $request)
    {
        $type = $request->type ?? 'shipments';
        $dateRange = $request->date_range ?? 'month';

        return $this->reportingService->exportReport($type, $dateRange);
    }

    public function customReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'metrics' => 'required|array'
        ]);

        $report = $this->reportingService->generateCustomReport(
            $request->start_date,
            $request->end_date,
            $request->metrics
        );

        if ($request->export) {
            return $this->reportingService->exportCustomReport($report);
        }

        return view('admin.reports.custom', compact('report'));
    }
}
