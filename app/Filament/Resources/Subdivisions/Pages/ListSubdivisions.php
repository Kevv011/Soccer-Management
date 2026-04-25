<?php

namespace App\Filament\Resources\Subdivisions\Pages;

use App\Filament\Resources\Subdivisions\SubdivisionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubdivisions extends ListRecords
{
    protected static string $resource = SubdivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
