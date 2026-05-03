<?php

namespace App\Filament\Resources\Federations;

use App\Filament\Resources\Federations\Infolists\FederationInfolist;
use App\Filament\Resources\Federations\Pages\CreateFederation;
use App\Filament\Resources\Federations\Pages\EditFederation;
use App\Filament\Resources\Federations\Pages\ListFederations;
use App\Filament\Resources\Federations\Pages\ViewFederation;
use App\Filament\Resources\Federations\Schemas\FederationForm;
use App\Filament\Resources\Federations\Tables\FederationsTable;
use App\Models\Federation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FederationResource extends Resource
{
    protected static ?string $model = Federation::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Federation';

    protected static ?string $pluralModelLabel = 'Federations';

    protected static string | \UnitEnum | null $navigationGroup = 'Federation Management';

    public static function form(Schema $schema): Schema
    {
        return FederationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FederationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FederationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFederations::route('/'),
            'create' => CreateFederation::route('/create'),
            'view' => ViewFederation::route('/{record}'),
            'edit' => EditFederation::route('/{record}/edit'),
        ];
    }
}
