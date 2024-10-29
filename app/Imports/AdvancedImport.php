<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Models\ImportLog;
use Illuminate\Support\Facades\DB;

abstract class AdvancedImport implements 
    ToCollection,
    WithHeadingRow,
    WithValidation,
    WithChunkReading,
    WithBatchInserts
{
    protected ImportLog $importLog;
    protected int $rowCount = 0;
    protected int $successCount = 0;
    protected array $failures = [];
    protected int $chunkSize = 1000;
    protected int $batchSize = 500;

    public function __construct(ImportLog $importLog)
    {
        $this->importLog = $importLog;
    }

    public function collection(Collection $rows)
    {
        $this->rowCount = $rows->count();

        DB::transaction(function () use ($rows) {
            $rows->chunk($this->batchSize)->each(function ($chunk) {
                $this->processChunk($chunk);
            });
        });
    }

    abstract protected function processChunk(Collection $chunk);

    public function chunkSize(): int
    {
        return $this->chunkSize;
    }

    public function batchSize(): int
    {
        return $this->batchSize;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getFailureCount(): int
    {
        return count($this->failures);
    }

    public function getFailures(): array
    {
        return $this->failures;
    }
}