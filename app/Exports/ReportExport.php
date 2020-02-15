<?php

namespace App\Exports;

use App\Exports\Contracts\ReportExportInterface;
use File;
use Illuminate\Support\Arr;

class ReportExport implements ReportExportInterface
{
    private $headers, $fields, $rows, $path;

    public function setPath()
    {
        $this->path = storage_path() . '/app/public/report.csv';
    }

    public function makeHeader($data)
    {
        if (!File::exists($this->path)) {
            File::put($this->path, "");
        }

        $file = fopen($this->path, 'r');
        $header = fgetcsv($file);
        $header = data_get($header, '0', '');
        $header = explode(';', $header);
        fclose($file);

        $fields = [];
        $data = (array) json_decode($data);
        $fields[] = array_keys($data);

        $fields = Arr::flatten($fields);
        $fields = array_filter(array_unique(array_merge($header, $fields)));

        $rows = file($this->path);
        if (data_get($rows, '0', null)) {
            $rows[0] = implode(';', $fields) . "\n";
            file_put_contents($this->path, implode($rows));
        } else {
            $file = fopen($this->path, 'w');
            fputcsv($file, $fields, ';');
            fclose($file);
        }

        $this->fields = $fields;
    }

    public function appendOrWriteFile()
    {
        if (File::exists($this->path)) {
            $this->file = fopen($this->path, 'a');
        } else {
            $this->file = fopen($this->path, 'w');
        }
    }

    public function makeRows($data)
    {
        $rows = [];
        $i = 0;
        $data = (array) json_decode($data);
        foreach ($this->fields as $field) {
            $rows[$i][] = data_get($data, $field, '');
        }
        $this->rows = $rows;
    }

    public function export(string $data)
    {
        $this->setPath();
        $this->makeHeader($data);
        $this->appendOrWriteFile();
        $this->makeRows($data);

        $rows = $this->rows;
        $fields = $this->fields;

        foreach ($rows as $row) {
            fputcsv($this->file, $row, ';');
        }
        fclose($this->file);
    }

    public function invertReport()
    {
        $this->setPath();

        $rows = file($this->path);
        $report = [];
        if ($rows > 2) {
            $header = array_shift($rows);
            $last = array_pop($rows);

            $report = array_merge($report, [$header]);
            $report = array_merge($report, [$last]);
            $report = array_merge($report, $rows);
            file_put_contents($this->path, implode($report));
        }
    }
}
