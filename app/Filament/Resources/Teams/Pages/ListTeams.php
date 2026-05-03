<?php

namespace App\Filament\Resources\Teams\Pages;

use App\Enums\ReportGenerationStatus;
use App\Enums\ReportType;
use App\Filament\Resources\Teams\TeamResource;
use App\Jobs\GenerateTeamReportJob;
use App\Models\ReportGeneration;
use App\Models\Team;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Utilities\Get;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('teamReport')
                ->label('Team report')
                ->icon('heroicon-o-document-chart-bar')
                ->color('gray')
                ->modalHeading('Team report')
                ->modalDescription('Queue a PDF generation job for the selected teams')
                ->modalSubmitActionLabel('Queue report')
                ->schema([
                    Checkbox::make('all_teams')
                        ->label('Include all teams')
                        ->live(),
                    Select::make('team_ids')
                        ->label('Teams')
                        ->options(fn(): array => Team::query()->orderBy('name')->pluck('name', 'id')->all())
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->hidden(fn(Get $get): bool => (bool) $get('all_teams'))
                        ->required(fn(Get $get): bool => ! $get('all_teams')),
                ])
                ->action(function (array $data): void {
                    $user = auth()->user();
                    $selectionSummary = (bool) ($data['all_teams'] ?? false)
                        ? 'All teams'
                        : count($data['team_ids'] ?? []) . ' selected teams';

                    $reportGeneration = ReportGeneration::query()->create([
                        'user_id' => $user?->id,
                        'report_type' => ReportType::Team,
                        'status' => ReportGenerationStatus::Pending,
                        'selection_summary' => $selectionSummary,
                        'requested_by_name' => $user?->name ?? 'Unknown user',
                        'requested_by_email' => $user?->email ?? 'unknown@example.com',
                        'filters' => [
                            'all_teams' => (bool) ($data['all_teams'] ?? false),
                            'team_ids' => $data['team_ids'] ?? [],
                        ],
                        'requested_at' => now(),
                    ]);

                    GenerateTeamReportJob::dispatch($user?->id, $reportGeneration->id, [
                        'all_teams' => (bool) ($data['all_teams'] ?? false),
                        'team_ids' => $data['team_ids'] ?? [],
                    ]);

                    Notification::make()
                        ->title('Team report queued successfully')
                        ->body('You will receive a notification when the PDF is ready.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
