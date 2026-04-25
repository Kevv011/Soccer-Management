<?php

namespace App\Filament\Resources\Subdivisions\Pages;

use App\Filament\Resources\Subdivisions\SubdivisionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubdivision extends EditRecord
{
    protected static string $resource = SubdivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
