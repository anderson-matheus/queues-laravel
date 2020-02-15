<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessReportData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $reportExport, $data;

    public function __construct($reportExport, $data)
    {
        $this->reportExport = $reportExport;
        $this->data = $data;
    }

    public function handle()
    {
        $this->reportExport->export($this->data);
    }
}
