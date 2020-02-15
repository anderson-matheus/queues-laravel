<?php

namespace App\Http\Controllers;

use App\Exports\Contracts\ReportExportInterface;
use App\Http\Requests\Report\ProcessReportDataRequest;
use App\Jobs\InvertReport;
use App\Jobs\ProcessReportData;
use Exception;
use Illuminate\Http\Request;
use Log;
use File;

class ReportController extends Controller
{
    private $reportExport;

    public function __construct(ReportExportInterface $reportExport)
    {
        $this->reportExport = $reportExport;
    }

    public function processReportData(ProcessReportDataRequest $request)
    {
        try {
            ProcessReportData::dispatch($this->reportExport, $request->data);
            InvertReport::dispatch($this->reportExport);
            return response()->json([
                'success' => true,
                'message' => 'seus dados estão sendo processados',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function downloadReport(Request $request)
    {
        $file = storage_path() . '/app/public/report.csv';
        if (!File::exists($file)) {
            Log::error('Relatório não existe');
            abort(404);
        }

        $headers = ['Content-Type: text/csv'];
        return response()->download($file, 'report.csv', $headers);
    }
}
