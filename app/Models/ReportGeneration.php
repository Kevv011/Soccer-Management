<?php

namespace App\Models;

use App\Enums\ReportGenerationStatus;
use App\Enums\ReportType;
use Database\Factories\ReportGenerationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'report_type',
    'status',
    'selection_summary',
    'requested_by_name',
    'requested_by_email',
    'file_disk',
    'file_path',
    'file_name',
    'filters',
    'requested_at',
    'completed_at',
    'error_message',
])]
class ReportGeneration extends Model
{
    /** @use HasFactory<ReportGenerationFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'report_type' => ReportType::class,
            'status' => ReportGenerationStatus::class,
            'filters' => 'array',
            'requested_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrl(): ?string
    {
        if (blank($this->file_disk) || blank($this->file_path)) {
            return null;
        }

        return Storage::disk($this->file_disk)->url($this->file_path);
    }
}
