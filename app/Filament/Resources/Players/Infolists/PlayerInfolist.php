<?php

namespace App\Filament\Resources\Players\Infolists;

use App\Enums\PlayerGender;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlayerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Player details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('birth_date')
                                ->date(),
                            TextEntry::make('gender')
                                ->formatStateUsing(function (PlayerGender | string | null $state): string {
                                    if ($state instanceof PlayerGender) {
                                        return PlayerGender::options()[$state->value] ?? $state->value;
                                    }

                                    if (blank($state)) {
                                        return '-';
                                    }

                                    return PlayerGender::options()[$state] ?? $state;
                                }),
                            TextEntry::make('team.name')
                                ->label('Team'),
                        ]),
                ]),
            Section::make('Federation context')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('team.federation.name')
                                ->label('Federation'),
                            TextEntry::make('team.federation.subdivision.country.name')
                                ->label('Country'),
                            TextEntry::make('team.federation.subdivision.name')
                                ->label('Subdivision'),
                            TextEntry::make('team.federation.municipality')
                                ->label('Municipality'),
                        ]),
                ]),
        ]);
    }
}
