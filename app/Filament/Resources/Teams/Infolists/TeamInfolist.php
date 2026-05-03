<?php

namespace App\Filament\Resources\Teams\Infolists;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Team details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('federation.name')
                                ->label('Federation'),
                            ImageEntry::make('crest')
                                ->label('Team crest')
                                ->state(fn ($record): string => $record->getFirstMediaUrl('crest', 'thumb') ?: $record->getFirstMediaUrl('crest'))
                                ->columnSpanFull(),
                        ]),
                ]),
            Section::make('Federation location')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('federation.subdivision.country.name')
                                ->label('Country'),
                            TextEntry::make('federation.subdivision.name')
                                ->label('Subdivision'),
                            TextEntry::make('federation.municipality')
                                ->label('Municipality'),
                            TextEntry::make('federation.address_line')
                                ->label('Address'),
                        ]),
                ]),
            Section::make('Player summary')
                ->schema([
                    TextEntry::make('players_count')
                        ->label('Registered players')
                        ->state(fn ($record): int => $record->players()->count()),
                ]),
        ]);
    }
}
