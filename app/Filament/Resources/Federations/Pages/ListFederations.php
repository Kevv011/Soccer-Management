<?php

namespace App\Filament\Resources\Federations\Pages;

use App\Enums\ReportGenerationStatus;
use App\Enums\ReportType;
use App\Filament\Resources\Federations\FederationResource;
use App\Jobs\GenerateFederationReportJob;
use App\Models\Federation;
use App\Models\ReportGeneration;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Utilities\Get;

class ListFederations extends ListRecords
{
    protected static string $resource = FederationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('federationReport')
                ->label('Federation report')
                ->icon('heroicon-o-document-chart-bar')
                ->color('gray')
                ->modalHeading('Federation report')
                ->modalDescription('Queue a PDF generation job for the selected federations')
                ->modalSubmitActionLabel('Queue report')
                ->schema([
                    Checkbox::make('all_federations')
                        ->label('Include all federations')
                        ->live(),
                    Select::make('federation_ids')
                        ->label('Federations')
                        ->options(fn(): array => Federation::query()->orderBy('name')->pluck('name', 'id')->all())
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->hidden(fn(Get $get): bool => (bool) $get('all_federations'))
                        ->required(fn(Get $get): bool => ! $get('all_federations')),
                ])
                ->action(function (array $data): void {
                    $user = auth()->user();
                    $selectionSummary = (bool) ($data['all_federations'] ?? false)
                        ? 'All federations'
                        : count($data['federation_ids'] ?? []) . ' selected federations';

                    $reportGeneration = ReportGeneration::query()->create([
                        'user_id' => $user?->id,
                        'report_type' => ReportType::Federation,
                        'status' => ReportGenerationStatus::Pending,
                        'selection_summary' => $selectionSummary,
                        'requested_by_name' => $user?->name ?? 'Unknown user',
                        'requested_by_email' => $user?->email ?? 'unknown@example.com',
                        'filters' => [
                            'all_federations' => (bool) ($data['all_federations'] ?? false),
                            'federation_ids' => $data['federation_ids'] ?? [],
                        ],
                        'requested_at' => now(),
                    ]);

                    GenerateFederationReportJob::dispatch($user?->id, $reportGeneration->id, [
                        'all_federations' => (bool) ($data['all_federations'] ?? false),
                        'federation_ids' => $data['federation_ids'] ?? [],
                    ]);

                    Notification::make()
                        ->title('Federation report queued successfully')
                        ->body('You will receive a notification when the PDF is ready.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
