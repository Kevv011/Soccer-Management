<?php

namespace App\Filament\Resources\Subdivisions;

use App\Filament\Resources\Subdivisions\Pages\CreateSubdivision;
use App\Filament\Resources\Subdivisions\Pages\EditSubdivision;
use App\Filament\Resources\Subdivisions\Pages\ListSubdivisions;
use App\Filament\Resources\Subdivisions\Schemas\SubdivisionForm;
use App\Filament\Resources\Subdivisions\Tables\SubdivisionsTable;
use App\Models\Subdivision;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubdivisionResource extends Resource
{
    protected static ?string $model = Subdivision::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Subdivisions';

    protected static ?string $modelLabel = 'Subdivision';

    protected static ?string $pluralModelLabel = 'Subdivisions';

    protected static string | \UnitEnum | null $navigationGroup = 'Catalogs';

    public static function form(Schema $schema): Schema
    {
        return SubdivisionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubdivisionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubdivisions::route('/'),
            'create' => CreateSubdivision::route('/create'),
            'edit' => EditSubdivision::route('/{record}/edit'),
        ];
    }
}
