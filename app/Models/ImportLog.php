<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $fillable = [
        'file_name',
        'imported_by',
        'total_rows',
        'success_rows',
        'failed_rows',
        'failed_rows_data',
        'status',
        'error_message'
    ];

    protected $casts = [
        'failed_rows_data' => 'array',
        'total_rows' => 'integer',
        'success_rows' => 'integer',
        'failed_rows' => 'integer'
    ];

    // Các constant cho status
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    // Scope query helpers
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    // Relationship với user nếu cần
    public function user()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}
