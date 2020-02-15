<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use File;

class ReportTest extends TestCase
{
    public function testProcessReportDataValidationError()
    {
        $response = $this->json('POST', '/api/report/process-data', ['data' => 'teste']);
        $response->assertStatus(422);
    }

    public function testDownloadReport()
    {
        $path = storage_path() . '/app/public/report.csv';
        if (!File::exists($path)) {
            File::put($path, "");
        }

        $response = $this->get('/api/report/download');
        $response->assertStatus(200);
    }

    public function testDownloadReportError()
    {
        $path = storage_path() . '/app/public/report.csv';
        if (File::exists($path)) {
            File::delete($path);
        }

        $response = $this->get('/api/report/download');
        $response->assertStatus(404);
    }
}
