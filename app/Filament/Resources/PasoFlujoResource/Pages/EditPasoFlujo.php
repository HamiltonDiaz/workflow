<?php

namespace App\Filament\Resources\PasoFlujoResource\Pages;

use App\Filament\Resources\PasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPasoFlujo extends EditRecord
{
    protected static string $resource = PasoFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
