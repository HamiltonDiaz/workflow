<?php

namespace App\Filament\Resources\FlujoTrabajoResource\Pages;

use App\Filament\Resources\FlujoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlujoTrabajo extends EditRecord
{
    protected static string $resource = FlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
