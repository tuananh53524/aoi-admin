<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessExcelImport;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdvancedExcelService
{
    public function export(
        Builder $query,
        string $exportClass,
        string $fileName,
        array $columns = [],
        array $columnFormats = [],
        array $columnWidths = [],
        bool $shouldAutoSize = true
    ): BinaryFileResponse {
        $export = new $exportClass($query);
        
        if (!empty($columns)) {
            $export->configureColumns($columns);
        }
        
        if (!empty($columnFormats)) {
            $export->setColumnFormats($columnFormats);
        }
        
        if (!empty($columnWidths)) {
            $export->setColumnWidths($columnWidths);
        }
        
        if (!$shouldAutoSize) {
            $export->disableAutoSize();
        }

        return Excel::download($export, $fileName);
    }

    public function queueImport(
        UploadedFile $file,
        string $importClass,
        int $userId
    ): void {
        ProcessExcelImport::dispatch(
            $file,
            $importClass,
            $userId
        );
    }
}