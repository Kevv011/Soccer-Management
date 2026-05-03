<?php

namespace App\Filament\Resources\ReportGenerations;

use App\Enums\RoleName;
use App\Filament\Resources\ReportGenerations\Pages\ListReportGenerations;
use App\Filament\Resources\ReportGenerations\Tables\ReportGenerationsTable;
use App\Models\ReportGeneration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReportGenerationResource extends Resource
{
    protected static ?string $model = ReportGeneration::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'file_name';

    protected static ?string $modelLabel = 'Report generation';

    protected static ?string $pluralModelLabel = 'Report generations';

    protected static string | \UnitEnum | null $navigationGroup = 'Reporting';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return ReportGenerationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReportGenerations::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with('user')->latest('requested_at');
        $user = auth()->user();

        if (! $user || ! $user->hasRole(RoleName::SuperAdmin->value)) {
            return $query->where('user_id', $user?->id);
        }

        return $query;
    }
}
