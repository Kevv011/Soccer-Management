<?php

namespace App\Filament\Resources\Players\Schemas;

use App\Enums\PlayerGender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Player details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('team_id')
                                ->relationship('team', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('name')
                                ->required()
                                ->maxLength(150),
                            DatePicker::make('birth_date')
                                ->required()
                                ->native(false)
                                ->maxDate(now()),
                            Select::make('gender')
                                ->required()
                                ->options(PlayerGender::options()),
                        ]),
                ]),
        ]);
    }
}
