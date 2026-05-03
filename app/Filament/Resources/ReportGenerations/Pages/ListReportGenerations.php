<?php

namespace App\Filament\Resources\ReportGenerations\Pages;

use App\Filament\Resources\ReportGenerations\ReportGenerationResource;
use Filament\Resources\Pages\ListRecords;

class ListReportGenerations extends ListRecords
{
    protected static string $resource = ReportGenerationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
