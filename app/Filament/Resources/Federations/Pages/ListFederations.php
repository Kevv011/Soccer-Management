<?php

namespace App\Filament\Resources\Federations\Pages;

use App\Filament\Resources\Federations\FederationResource;
use App\Models\Federation;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Actions\CreateAction;
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
                ->modalDescription('Build a report dataset for federations')
                ->modalSubmitActionLabel('Build report data')
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
                ->action(function (array $data) {
                    return redirect()->route('reports.federations.index', [
                        'all_federations' => (int) ($data['all_federations'] ?? false),
                        'federation_ids' => $data['federation_ids'] ?? [],
                    ]);
                }),
        ];
    }
}
