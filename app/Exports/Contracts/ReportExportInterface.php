<?php

namespace App\Exports\Contracts;

interface ReportExportInterface
{
    public function export(string $data);
}