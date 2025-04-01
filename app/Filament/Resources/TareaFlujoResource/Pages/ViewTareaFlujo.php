<?php

namespace App\Filament\Resources\TareaFlujoResource\Pages;

use App\Filament\Resources\TareaFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTareaFlujo extends ViewRecord
{
    protected static string $resource = TareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
