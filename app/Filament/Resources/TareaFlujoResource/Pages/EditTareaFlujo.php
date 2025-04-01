<?php

namespace App\Filament\Resources\TareaFlujoResource\Pages;

use App\Filament\Resources\TareaFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTareaFlujo extends EditRecord
{
    protected static string $resource = TareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
