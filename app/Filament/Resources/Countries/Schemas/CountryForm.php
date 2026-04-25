<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Country details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(150),
                            TextInput::make('iso_name')
                                ->required()
                                ->maxLength(100),
                            TextInput::make('iso')
                                ->required()
                                ->maxLength(2)
                                ->minLength(2)
                                ->unique(ignoreRecord: true)
                                ->uppercase(),
                            TextInput::make('iso3')
                                ->required()
                                ->maxLength(3)
                                ->minLength(3)
                                ->unique(ignoreRecord: true)
                                ->uppercase(),
                        ]),
                ]),
        ]);
    }
}
