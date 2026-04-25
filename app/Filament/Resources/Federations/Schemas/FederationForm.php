<?php

namespace App\Filament\Resources\Federations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class FederationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('General information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(200)
                                ->columnSpanFull()
                                ->rule(function (?Model $record, callable $get) {
                                    return Rule::unique('federations', 'name')
                                        ->where('subdivision_id', $get('subdivision_id'))
                                        ->where('municipality', $get('municipality'))
                                        ->ignore($record);
                                }),
                            DatePicker::make('foundation_date')
                                ->required()
                                ->native(false)
                                ->maxDate(now()),
                            SpatieMediaLibraryFileUpload::make('logo')
                                ->label('Federation logo')
                                ->collection('logo')
                                ->image()
                                ->imageEditor()
                                ->maxSize(5 * 1024),
                        ]),
                ]),
            Section::make('Location')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('subdivision_id')
                                ->relationship('subdivision', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('municipality')
                                ->required()
                                ->maxLength(150),
                            TextInput::make('address_line')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ]),
                ]),
        ]);
    }
}
