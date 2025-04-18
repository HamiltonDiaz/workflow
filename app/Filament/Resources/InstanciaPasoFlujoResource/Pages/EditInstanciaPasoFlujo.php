<?php

namespace App\Filament\Resources\InstanciaPasoFlujoResource\Pages;

use App\Filament\Resources\InstanciaPasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstanciaPasoFlujo extends EditRecord
{
    protected static string $resource = InstanciaPasoFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
