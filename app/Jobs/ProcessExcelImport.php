<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ImportLog;
use App\Events\ImportCompleted;

class ProcessExcelImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $importClass;
    protected $userId;
    protected $importLog;

    public function __construct($file, $importClass, $userId)
    {
        $this->file = $file;
        $this->importClass = $importClass;
        $this->userId = $userId;
    }

    public function handle()
    {
        try {
            // Create import log
            $this->importLog = ImportLog::create([
                'user_id' => $this->userId,
                'file_name' => $this->file->getClientOriginalName(),
                'status' => 'processing'
            ]);

            // Process import
            $import = new $this->importClass($this->importLog);
            Excel::import($import, $this->file);

            // Update log
            $this->importLog->update([
                'status' => 'completed',
                'total_rows' => $import->getRowCount(),
                'successful_rows' => $import->getSuccessCount(),
                'failed_rows' => $import->getFailureCount(),
                'errors' => $import->getFailures()
            ]);

            // Fire event
            // event(new ImportCompleted($this->importLog)); tạo và xử lý event sau khi ghi log ví dụ: gửi mail thông báo sau khi import || export xong
        } catch (\Exception $e) {
            $this->importLog->update([
                'status' => 'failed',
                'errors' => [['message' => $e->getMessage()]]
            ]);

            throw $e;
        }
    }
}