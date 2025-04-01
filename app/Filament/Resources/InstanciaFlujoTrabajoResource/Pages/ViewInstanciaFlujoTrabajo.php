<?php

namespace App\Filament\Resources\InstanciaFlujoTrabajoResource\Pages;

use App\Filament\Resources\InstanciaFlujoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInstanciaFlujoTrabajo extends ViewRecord
{
    protected static string $resource = InstanciaFlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
