<?php

namespace App\Filament\Resources\Federations\Schemas;

use App\Models\Country;
use App\Models\Subdivision;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
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
                            Select::make('country_id')
                                ->label('Country')
                                ->options(fn (): array => Country::query()->orderBy('name')->pluck('name', 'id')->all())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->dehydrated(false)
                                ->afterStateHydrated(function (Select $component, ?Model $record): void {
                                    if (! $record?->relationLoaded('subdivision')) {
                                        $record?->loadMissing('subdivision.country');
                                    }

                                    $component->state($record?->subdivision?->country_id);
                                })
                                ->afterStateUpdated(fn (Set $set) => $set('subdivision_id', null)),
                            Select::make('subdivision_id')
                                ->options(fn (Get $get): array => Subdivision::query()
                                    ->when(
                                        filled($get('country_id')),
                                        fn ($query) => $query->where('country_id', $get('country_id')),
                                    )
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->all())
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
