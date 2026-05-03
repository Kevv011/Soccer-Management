<?php

namespace App\Filament\Resources\Teams\Pages;

use App\Filament\Resources\Teams\TeamResource;
use App\Models\Team;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
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
                ->modalDescription('Build a report dataset for teams')
                ->modalSubmitActionLabel('Build report data')
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
                ->action(function (array $data) {
                    return redirect()->route('reports.teams.index', [
                        'all_teams' => (int) ($data['all_teams'] ?? false),
                        'team_ids' => $data['team_ids'] ?? [],
                    ]);
                }),
        ];
    }
}
