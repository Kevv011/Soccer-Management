<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Team details')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('federation_id')
                                ->relationship('federation', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('name')
                                ->required()
                                ->maxLength(150)
                                ->rule(function (?Model $record, callable $get) {
                                    return Rule::unique('teams', 'name')
                                        ->where('federation_id', $get('federation_id'))
                                        ->ignore($record);
                                }),
                            SpatieMediaLibraryFileUpload::make('crest')
                                ->label('Team crest')
                                ->collection('crest')
                                ->image()
                                ->imageEditor()
                                ->maxSize(5 * 1024)
                                ->columnSpanFull(),
                        ]),
                ]),
        ]);
    }
}
