<?php

namespace App\Filament\Resources\InstanciaPasoFlujoResource\Pages;

use App\Filament\Resources\InstanciaPasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInstanciaPasoFlujo extends ViewRecord
{
    protected static string $resource = InstanciaPasoFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
