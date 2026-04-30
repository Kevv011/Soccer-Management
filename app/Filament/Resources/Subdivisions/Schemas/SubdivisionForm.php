<?php

namespace App\Filament\Resources\Subdivisions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class SubdivisionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Subdivision details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('country_id')
                                ->relationship('country', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('name')
                                ->required()
                                ->maxLength(150),
                            TextInput::make('code')
                                ->required()
                                ->maxLength(20)
                                ->formatStateUsing(fn(?string $state): ?string => $state ? strtoupper($state) : null)
                                ->dehydrateStateUsing(fn(?string $state): ?string => $state ? strtoupper($state) : null)
                                ->rule(function (?Model $record, callable $get) {
                                    return Rule::unique('subdivisions', 'code')
                                        ->where('country_id', $get('country_id'))
                                        ->ignore($record);
                                }),
                        ]),
                ]),
        ]);
    }
}
