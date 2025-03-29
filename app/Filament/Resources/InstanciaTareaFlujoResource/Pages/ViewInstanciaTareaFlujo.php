<?php

namespace App\Filament\Resources\InstanciaTareaFlujoResource\Pages;

use App\Filament\Resources\InstanciaTareaFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInstanciaTareaFlujo extends ViewRecord
{
    protected static string $resource = InstanciaTareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
