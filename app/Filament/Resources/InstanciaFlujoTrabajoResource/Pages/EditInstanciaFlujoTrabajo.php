<?php

namespace App\Filament\Resources\InstanciaFlujoTrabajoResource\Pages;

use App\Filament\Resources\InstanciaFlujoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstanciaFlujoTrabajo extends EditRecord
{
    protected static string $resource = InstanciaFlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
