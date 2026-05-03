<?php

namespace App\Filament\Resources\Federations\Pages;

use App\Filament\Resources\Federations\FederationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFederation extends ViewRecord
{
    protected static string $resource = FederationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
