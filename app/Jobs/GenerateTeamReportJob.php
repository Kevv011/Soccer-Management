<?php

namespace App\Jobs;

use App\Actions\Reports\BuildTeamReportData;
use App\Enums\ReportGenerationStatus;
use App\Models\ReportGeneration;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class GenerateTeamReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array{all_teams?: bool, team_ids?: array<int, int|string>}  $filters
     */
    public function __construct(
        public int $userId,
        public int $reportGenerationId,
        public array $filters = [],
    ) {}

    public function handle(BuildTeamReportData $buildTeamReportData): void
    {
        $user = User::query()->find($this->userId);
        $reportGeneration = ReportGeneration::query()->find($this->reportGenerationId);

        if (! $reportGeneration) {
            return;
        }

        $reportData = $buildTeamReportData->handle($this->filters);
        $timestamp = now()->format('YmdHis');
        $filename = "team-report-{$timestamp}-" . Str::lower(Str::random(6)) . '.pdf';
        $path = "reports/teams/{$filename}";

        $pdf = Pdf::loadView('reports.team-report', $reportData)
            ->setPaper('a4', 'portrait');

        Storage::disk('public')->put($path, $pdf->output());

        $reportGeneration->update([
            'status' => ReportGenerationStatus::Completed,
            'file_disk' => 'public',
            'file_path' => $path,
            'file_name' => $filename,
            'completed_at' => now(),
            'error_message' => null,
        ]);

        if (! $user) {
            return;
        }

        Notification::make()
            ->title('Team report is ready')
            ->body('The PDF was generated successfully and is ready to open.')
            ->success()
            ->actions([
                Action::make('openReport')
                    ->label('Open report')
                    ->button()
                    ->url(Storage::disk('public')->url($path), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($user, isEventDispatched: true);
    }

    public function failed(?Throwable $exception): void
    {
        $reportGeneration = ReportGeneration::query()->find($this->reportGenerationId);
        $user = User::query()->find($this->userId);

        if ($reportGeneration) {
            $reportGeneration->update([
                'status' => ReportGenerationStatus::Failed,
                'completed_at' => now(),
                'error_message' => $exception?->getMessage(),
            ]);
        }

        if (! $user) {
            return;
        }

        Notification::make()
            ->title('Team report failed')
            ->body('The PDF could not be generated. Review the report history for details.')
            ->danger()
            ->sendToDatabase($user, isEventDispatched: true);
    }
}
