<?php

namespace App\Filament\Resources\Federations\Infolists;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FederationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('General information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('foundation_date')
                                ->date(),
                            ImageEntry::make('logo')
                                ->label('Federation logo')
                                ->state(fn ($record): string => $record->getFirstMediaUrl('logo', 'thumb') ?: $record->getFirstMediaUrl('logo'))
                                ->columnSpanFull(),
                        ]),
                ]),
            Section::make('Location')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('subdivision.country.name')
                                ->label('Country'),
                            TextEntry::make('subdivision.name')
                                ->label('Subdivision'),
                            TextEntry::make('municipality'),
                            TextEntry::make('address_line')
                                ->columnSpanFull(),
                        ]),
                ]),
            Section::make('Operational summary')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('teams_count')
                                ->label('Teams')
                                ->state(fn ($record): int => $record->teams()->count()),
                            TextEntry::make('players_count')
                                ->label('Players')
                                ->state(fn ($record): int => $record->teams()->withCount('players')->get()->sum('players_count')),
                        ]),
                ]),
        ]);
    }
}
