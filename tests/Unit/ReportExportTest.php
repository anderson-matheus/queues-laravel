<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exports\ReportExport;
use File;

class ReportExportTest extends TestCase
{
    public function testExport()
    {
        $reportExport = new ReportExport;
        $path = storage_path() . '/app/public/report.csv';
        if (File::exists($path)) {
            File::delete($path);
        }

        $reportExport->export(json_encode(['name' => 'alfred']));

        return File::exists($path) ? $this->assertTrue(true) : $this->assertTrue(false);
    }
}
